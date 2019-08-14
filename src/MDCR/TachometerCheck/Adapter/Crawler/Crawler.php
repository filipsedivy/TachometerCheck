<?php

namespace MDCR\TachometerCheck\Adapter\Crawler;

use DateTime;
use Goutte\Client;
use MDCR\TachometerCheck\Adapter\OCR;
use MDCR\TachometerCheck\Adapter\RemoteImage\RemoteImage;
use MDCR\TachometerCheck\Entity\History;
use MDCR\TachometerCheck\Exceptions\Crawler\FormErrorData;
use MDCR\TachometerCheck\Repository\Histories;

final class Crawler implements IAdapter
{
    /** @var Client */
    private $goutte;

    /** @var OCR\IAdapter */
    private $ocr;

    public function __construct(OCR\IAdapter $ocr, Client $goutte)
    {
        $this->goutte = $goutte;
        $this->ocr = $ocr;
    }

    public function getHistoriesByVinCode(string $vinCode): Histories
    {
        $homepage = $this->goutte->request('GET', 'https://www.kontrolatachometru.cz');

        $captcha = $homepage->filter('#ASPxCaptcha1_IMG')->image();
        $remoteImage = new RemoteImage($captcha->getUri());

        $form = $homepage->selectButton('Potvrdit')->form();
        $crawler = $this->goutte->submit($form, [
            'tbVIN' => $vinCode,
            'ASPxCaptcha1$TB' => $this->ocr->getText($remoteImage)
        ]);

        $crawler
            ->filter('#lblErrorData')
            ->each(function (\Symfony\Component\DomCrawler\Crawler $crawler) {
                throw new FormErrorData($crawler->text());
            });

        $histories = new Histories();

        $crawler
            ->filter('tr.TachometerDataGridItem')
            ->each(function (\Symfony\Component\DomCrawler\Crawler $crawler) use ($histories) {
                $column = $crawler->filter('td');

                $dateOfInspection = DateTime::createFromFormat('d.m.Y', $column->eq(0)->text());
                $typeOfInspection = trim($column->eq(1)->text());
                $mileage = (int)preg_replace('/[^0-9]/', '', $column->eq(2)->text());
                $noteColumn = trim($column->eq(3)->text());
                $note = mb_strlen($noteColumn) <= 1 ? null : $noteColumn;

                $history = new History();
                $history
                    ->setDateOfInspection($dateOfInspection)
                    ->setTypeOfInspection($typeOfInspection)
                    ->setMileage($mileage)
                    ->setNote($note);

                $histories->add($history);
            });

        return $histories;
    }
}