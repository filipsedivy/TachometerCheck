<?php declare(strict_types=1);

namespace MDCR\TachometerCheck\Entity;

use DateTime;

final class History
{
    /** @var DateTime */
    private $dateOfInspection;

    /** @var string */
    private $typeOfInspection;

    /** @var integer */
    private $mileage;

    /** @var string|null */
    private $note;

    /**
     * @return DateTime
     */
    public function getDateOfInspection(): DateTime
    {
        return $this->dateOfInspection;
    }

    /**
     * @param DateTime $dateOfInspection
     * @return History
     */
    public function setDateOfInspection(DateTime $dateOfInspection): History
    {
        $this->dateOfInspection = $dateOfInspection;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeOfInspection(): string
    {
        return $this->typeOfInspection;
    }

    /**
     * @param string $typeOfInspection
     * @return History
     */
    public function setTypeOfInspection(string $typeOfInspection): History
    {
        $this->typeOfInspection = $typeOfInspection;
        return $this;
    }

    /**
     * @return int
     */
    public function getMileage(): int
    {
        return $this->mileage;
    }

    /**
     * @param int $mileage
     * @return History
     */
    public function setMileage(int $mileage): History
    {
        $this->mileage = $mileage;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     * @return History
     */
    public function setNote(?string $note): History
    {
        $this->note = $note;
        return $this;
    }
}