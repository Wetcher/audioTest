<?php

namespace App\Service;

use App\Model\Chapter;
use App\Model\TimePeriod;
use App\Service\ServiceInterface\ChapterServiceInterface;

class ChapterService implements ChapterServiceInterface
{
    /**
     * @param Chapter[] $chapters
     * @param int $maxSegmentDuration
     *
     * @return Chapter[]
     */
    public function combineChaptersIntervals(array $chapters, int $maxSegmentDuration): array
    {
        foreach ($chapters as $chapter) {
            $audioSegments = $chapter->getSegments();
            $audioSegmentsCount = count($audioSegments);
            if ($audioSegmentsCount <= 1) {
                continue;
            }

            $newSegments = [];
            $combinedSegment = new TimePeriod($audioSegments[0]->getStartDuration(), $audioSegments[0]->getEndDuration());

            for ($i = 1; $i < $audioSegmentsCount; $i++) {
                $currentSegment = $audioSegments[$i];

                // End duration should be null for the last segment.
                if ($currentSegment->getEndDuration()) {
                    $newCombinedSegment = new TimePeriod($combinedSegment->getStartDuration(), $currentSegment->getEndDuration());

                    if ($newCombinedSegment->intervalInMilliseconds() >= $maxSegmentDuration) {
                        $newSegments[] = $combinedSegment;
                        $combinedSegment = new TimePeriod($currentSegment->getStartDuration(), $currentSegment->getEndDuration());
                    } else {
                        $combinedSegment->setEndDuration($currentSegment->getEndDuration());
                    }
                } else {
                    // Add segment after last silence. No information about it's length so it is separated from previous segment.
                    $newSegments[] = $combinedSegment;
                    $combinedSegment = new TimePeriod($currentSegment->getStartDuration(), null);
                }
            }

            $newSegments[] = $combinedSegment;
            $chapter->setSegments($newSegments);
        }

        return $chapters;
    }
}
