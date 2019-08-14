<?php declare(strict_types=1);

namespace MDCR\TachometerCheck\Exceptions\OCR;

use MDCR\TachometerCheck\Exceptions\RuntimeException;
use Throwable;

final class WaitingForSolution extends RuntimeException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Waiting for a solution', 0, $previous);
    }
}