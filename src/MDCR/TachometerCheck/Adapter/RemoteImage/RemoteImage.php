<?php declare(strict_types=1);

namespace MDCR\TachometerCheck\Adapter\RemoteImage;

final class RemoteImage implements IAdapter
{
    /** @var string */
    private $url;

    /** @var string|null */
    private $binary;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getImage(): string
    {
        if ($this->binary === null) {
            $this->binary = file_get_contents($this->getUrl());
        }

        return $this->binary;
    }
}