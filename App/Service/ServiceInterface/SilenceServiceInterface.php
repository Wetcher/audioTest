<?php

namespace App\Service\ServiceInterface;

use App\Model\Chapter;
use App\Model\TimePeriod;

interface SilenceServiceInterface
{
    /**
     * @param TimePeriod[] $silenceIntervals
     * @param int $silenceChapterDuration
     * @param int $silenceSegmentDuration
     *
     * @return Chapter[]
     */
    public function convertIntervalsIntoChapters(array $silenceIntervals, int $silenceChapterDuration, int $silenceSegmentDuration): array;
}

