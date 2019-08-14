<?php declare(strict_types=1);

namespace MDCR\TachometerCheck\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use MDCR\TachometerCheck\Entity\History;

class Histories implements Repository
{
    /** @var ArrayCollection */
    private $collection;

    public function __construct()
    {
        $this->collection = new ArrayCollection();
    }

    public function add(History $history): self
    {
        $this->collection->add($history);
        return $this;
    }

    public function getCollection(): ArrayCollection
    {
        return $this->collection;
    }

    public function getIterator()
    {
        return $this->collection->getIterator();
    }

    public function count()
    {
        return $this->collection->count();
    }
}