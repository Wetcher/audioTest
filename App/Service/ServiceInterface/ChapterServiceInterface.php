<?php

namespace App\Service\ServiceInterface;

use App\Model\Chapter;

interface ChapterServiceInterface
{
    /**
     * @param Chapter[] $chapters
     * @param int $maxSegmentDuration
     * @return Chapter[]
     */
    public function combineChaptersIntervals(array $chapters, int $maxSegmentDuration): array;
}

