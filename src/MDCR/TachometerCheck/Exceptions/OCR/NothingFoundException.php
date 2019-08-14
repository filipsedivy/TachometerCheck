<?php declare(strict_types=1);

namespace MDCR\TachometerCheck\Exceptions\OCR;

use MDCR\TachometerCheck\Exceptions\RuntimeException;
use Throwable;

final class NothingFoundException extends RuntimeException
{
    public function __construct(Throwable $previous = null)
    {
        $message = 'No OCR record found';
        parent::__construct($message, 0, $previous);
    }
}