<?php declare(strict_types=1);

namespace MDCR\TachometerCheck\Adapter\OCR;

use MDCR\TachometerCheck\Adapter\RemoteImage;

interface IAdapter
{
    public function getText(RemoteImage\IAdapter $adapter): string;
}