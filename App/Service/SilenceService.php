<?php

namespace App\Service;

use App\Model\Chapter;
use App\Model\TimePeriod;
use App\Service\ServiceInterface\SilenceServiceInterface;
use Carbon\CarbonInterval;

class SilenceService implements SilenceServiceInterface
{
    /**
     * @param TimePeriod[] $silenceIntervals
     * @param int $silenceChapterDuration
     * @param int $silenceSegmentDuration
     *
     * @return Chapter[]
     */
    public function convertIntervalsIntoChapters(array $silenceIntervals, int $silenceChapterDuration, int $silenceSegmentDuration): array
    {
        $segmentStart = CarbonInterval::fromString('PT0S');
        $chapterSegments = [];
        $chapters = [];

        foreach ($silenceIntervals as $silenceDuration) {
            $audioStops = $silenceDuration->getStartDuration();
            $audioStarts = $silenceDuration->getEndDuration();

            if ($silenceDuration->intervalInMilliseconds() >= $silenceChapterDuration) {
                $chapterSegments[] = new TimePeriod($segmentStart, $audioStops);
                $chapters[] = new Chapter($chapterSegments);
                $chapterSegments = [];
                $segmentStart = $audioStarts;
            } else if ($silenceDuration->intervalInMilliseconds() >= $silenceSegmentDuration) {
                $chapterSegments[] = new TimePeriod($segmentStart, $audioStops);
                $segmentStart = $audioStarts;
            }
        }

        // Need this last step to add audio segment after last silence
        $chapterSegments[] = new TimePeriod($silenceIntervals[count($silenceIntervals) - 1]->getEndDuration(), null);
        $chapters[] = new Chapter($chapterSegments);

        return $chapters;
    }
}
