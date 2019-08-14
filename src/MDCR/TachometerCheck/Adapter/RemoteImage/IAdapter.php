<?php declare(strict_types=1);

namespace MDCR\TachometerCheck\Adapter\RemoteImage;

interface IAdapter
{
    public function __construct(string $url);

    public function getUrl(): string;

    public function getImage(): string;
}