<?php

namespace App\Model;

use Carbon\CarbonInterval;

class TimePeriod
{
    /**
     * @var CarbonInterval|null
     */
    private ?CarbonInterval $startDuration;

    /**
     * @var CarbonInterval|null
     */
    private ?CarbonInterval $endDuration;

    /**
     * TimePeriod constructor.
     *
     * @param CarbonInterval|null $startDuration
     * @param CarbonInterval|null $endDuration
     */
    public function __construct(CarbonInterval $startDuration = null, CarbonInterval $endDuration = null)
    {
        $this->startDuration = $startDuration;
        $this->endDuration = $endDuration;
    }

    /**
     * @return int
     */
    public function intervalInMilliseconds(): int
    {
        if ($this->startDuration && $this->endDuration) {
            $startMs = $this->startDuration->total('milliseconds');
            $endMs = $this->endDuration->total('milliseconds');

            return $endMs - $startMs;
        }

        return -1;
    }

    /**
     * @return CarbonInterval|null
     */
    public function getStartDuration(): ?CarbonInterval
    {
        return $this->startDuration;
    }

    /**
     * @return CarbonInterval|null
     */
    public function getEndDuration(): ?CarbonInterval
    {
        return $this->endDuration;
    }

    /**
     * @param CarbonInterval|null $endDuration
     */
    public function setEndDuration(?CarbonInterval $endDuration): void
    {
        $this->endDuration = $endDuration;
    }
}
