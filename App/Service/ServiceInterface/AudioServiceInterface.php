<?php

namespace App\Service\ServiceInterface;

use App\Model\Chapter;
use App\Model\TimePeriod;

interface AudioServiceInterface
{
    /**
     * @param TimePeriod[] $silenceIntervals
     * @param int $silenceChapterDuration
     * @param int $maxSegmentDuration
     * @param int $silenceSegmentDuration
     * @return Chapter[]
     */
    public function convertSilenceIntervalsToChapters(array $silenceIntervals, int $silenceChapterDuration, int $maxSegmentDuration, int $silenceSegmentDuration): array;
}

