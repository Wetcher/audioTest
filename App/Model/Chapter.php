<?php

namespace App\Model;

class Chapter
{
    /**
     * @var TimePeriod[]
     */
    private array $segments;

    /**
     * Chapter constructor.
     * @param array $segments
     */
    public function __construct(array $segments = [])
    {
        $this->segments = $segments;
    }

    /**
     * @return TimePeriod[]
     */
    public function getSegments(): array
    {
        return $this->segments;
    }

    /**
     * @param array $segments
     */
    public function setSegments(array $segments): void
    {
        $this->segments = $segments;
    }
}
