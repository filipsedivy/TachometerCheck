<?php

namespace MDCR\TachometerCheck\Adapter\OCR;

use GuzzleHttp\Client;
use MDCR\TachometerCheck\Adapter\RemoteImage;
use MDCR\TachometerCheck\Exceptions\OCR\BadResponse;
use MDCR\TachometerCheck\Exceptions\OCR\WaitingForSolution;

final class TwoCaptcha implements IAdapter
{
    private const BASE_URL = 'https://2captcha.com';

    /** @var string */
    private $apiKey;

    /** @var Client */
    private $client;

    public function __construct(string $apiKey, Client $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    public function getText(RemoteImage\IAdapter $adapter): string
    {
        $id = $this->sendToSolve($adapter);

        $captcha = null;

        do {
            try {
                $captcha = $this->checkSolve($id);
            } catch (WaitingForSolution $e) {
                sleep(.5);
            }
        } while ($captcha === null);

        return $captcha;
    }

    private function sendToSolve(RemoteImage\IAdapter $adapter): int
    {
        $response = $this->client->post(self::BASE_URL . '/in.php', [
            'multipart' => [
                [
                    'name' => 'key',
                    'contents' => $this->apiKey
                ],

                [
                    'name' => 'file',
                    'contents' => $adapter->getImage(),
                    'filename' => 'captcha.png',
                    'headers' => ['Content-Type' => 'image/png']
                ]
            ]
        ]);

        $body = $response->getBody()->getContents();

        if (strpos($body, 'ERROR') === 0) {
            throw new BadResponse($body);
        }

        [$result, $id] = explode('|', $body);

        if ($result !== 'OK') {
            throw new BadResponse('Bad result [' . $result . ']');
        }

        return (int)$id;
    }

    private function checkSolve(int $id): string
    {
        $query = [
            'key' => $this->apiKey,
            'action' => 'get',
            'id' => $id
        ];

        $response = $this->client->get(self::BASE_URL . '/res.php?' . http_build_query($query));

        $body = $response->getBody()->getContents();

        if (strpos($body, 'ERROR') === 0) {
            throw new BadResponse($body);
        }

        if ($body === 'CAPCHA_NOT_READY') {
            throw new WaitingForSolution();
        }

        [$state, $result] = explode('|', $body);

        if ($state !== 'OK') {
            throw new BadResponse('Bad result [' . $body . ']');
        }

        return $result;
    }
}