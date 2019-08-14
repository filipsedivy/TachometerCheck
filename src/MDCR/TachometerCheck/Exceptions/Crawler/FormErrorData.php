<?php declare(strict_types=1);

namespace MDCR\TachometerCheck\Exceptions\Crawler;

use MDCR\TachometerCheck\Exceptions\RuntimeException;
use Throwable;

final class FormErrorData extends RuntimeException
{
    public function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}