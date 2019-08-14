<?php

namespace MDCR\TachometerCheck\Adapter\Crawler;

use MDCR\TachometerCheck\Repository\Histories;

interface IAdapter
{
    public function getHistoriesByVinCode(string $vinCode): Histories;
}