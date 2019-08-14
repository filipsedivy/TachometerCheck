<?php

namespace MDCR\TachometerCheck\Adapter\OCR;

use Google\Cloud\Vision\V1\EntityAnnotation;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use MDCR\TachometerCheck\Adapter\RemoteImage;
use MDCR\TachometerCheck\Exceptions\OCR\NothingFoundException;

final class GoogleVision implements IAdapter
{
    private $imageAnnotator;

    public function __construct(ImageAnnotatorClient $client)
    {
        $this->imageAnnotator = $client;
    }

    public function getText(RemoteImage\IAdapter $adapter): string
    {
        $response = $this->imageAnnotator->textDetection($adapter->getUrl());
        $texts = $response->getTextAnnotations();

        if ($texts->count() === 0) {
            throw new NothingFoundException();
        }

        foreach ($texts as $text) {
            if ($text instanceof EntityAnnotation) {
                $description = $text->getDescription();
                return trim($description);
            }
        }

        throw new NothingFoundException();
    }
}