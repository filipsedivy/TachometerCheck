<?php declare(strict_types=1);

namespace MDCR\TachometerCheck;

use MDCR\TachometerCheck\Adapter\Crawler;
use MDCR\TachometerCheck\Repository\Histories;

class TachometerCheck
{
    /** @var Crawler\IAdapter */
    private $crawler;

    public function __construct(Crawler\IAdapter $crawler)
    {
        $this->crawler = $crawler;
    }

    public function getHistory(string $vinCode): Histories
    {
        return $this->crawler->getHistoriesByVinCode($vinCode);
    }
}