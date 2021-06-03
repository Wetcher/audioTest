<?php

namespace App\Service;

use App\Model\Chapter;
use App\Model\TimePeriod;
use App\Service\ServiceInterface\AudioServiceInterface;
use App\Service\ServiceInterface\ChapterServiceInterface;
use App\Service\ServiceInterface\SilenceServiceInterface;

class AudioService implements AudioServiceInterface
{
    /**
     * @var SilenceServiceInterface
     */
    private SilenceServiceInterface $silenceService;

    /**
     * @var ChapterServiceInterface
     */
    private ChapterServiceInterface $chapterService;

    /**
     * AudioService constructor.
     *
     * @param SilenceServiceInterface $silenceService
     * @param ChapterServiceInterface $chapterService
     */
    public function __construct(SilenceServiceInterface $silenceService, ChapterServiceInterface $chapterService)
    {
        $this->silenceService = $silenceService;
        $this->chapterService = $chapterService;
    }

    /**
     * @param TimePeriod[] $silenceIntervals
     * @param int $silenceChapterDuration
     * @param int $maxSegmentDuration
     * @param int $silenceSegmentDuration
     *
     * @return Chapter[]
     */
    public function convertSilenceIntervalsToChapters(array $silenceIntervals, int $silenceChapterDuration, int $maxSegmentDuration, int $silenceSegmentDuration): array
    {
        $chapters = $this->silenceService->convertIntervalsIntoChapters($silenceIntervals, $silenceChapterDuration, $silenceSegmentDuration);
        $chapters = $this->chapterService->combineChaptersIntervals($chapters, $maxSegmentDuration);

        return $chapters;
    }
}
