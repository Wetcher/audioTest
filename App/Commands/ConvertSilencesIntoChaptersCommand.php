<?php

namespace App\Commands;

use App\Service\ServiceInterface\AudioServiceInterface;
use App\Service\ServiceInterface\AudioServiceParserInterface;
use App\Service\ServiceInterface\ChapterConverterInterface;
use App\Service\ServiceInterface\FileServiceInterface;
use Carbon\CarbonInterval;
use Exception;

class ConvertSilencesIntoChaptersCommand implements CommandInterface
{
    /**
     * @var AudioServiceParserInterface
     */
    private $audioServiceParser;

    /**
     * @var ChapterConverterInterface
     */
    private $chapterConverter;

    /**
     * @var AudioServiceInterface
     */
    private $audioService;

    /**
     * @var FileServiceInterface
     */
    private $fileService;

    /**
     * ConvertSilencesIntoChaptersCommand constructor.
     *
     * @param FileServiceInterface $fileService
     * @param AudioServiceParserInterface $audioServiceParser
     * @param ChapterConverterInterface $chapterConverter
     * @param AudioServiceInterface $audioService
     */
    public function __construct(FileServiceInterface $fileService, AudioServiceParserInterface $audioServiceParser, ChapterConverterInterface $chapterConverter, AudioServiceInterface $audioService)
    {
        $this->fileService = $fileService;
        $this->audioServiceParser = $audioServiceParser;
        $this->chapterConverter = $chapterConverter;
        $this->audioService = $audioService;
    }

    /**
     * @param array $args
     *
     * @throws Exception
     */
    public function execute(array $args): void
    {
        $path = $args['path'] ?? '';
        $silenceChapterDuration = CarbonInterval::fromString(($args['silence-chapter-duration'] ?? ''))->total('milliseconds');
        $maxSegmentDuration = CarbonInterval::fromString($args['max-segment-duration'] ?? '')->total('milliseconds');
        $silenceSegmentDuration = CarbonInterval::fromString($args['silence-segment-duration'] ?? '')->total('milliseconds');

        if ($silenceChapterDuration <= $silenceSegmentDuration) {
            throw new Exception('Segment chapter silence duration is greater then chapter silence duration');
        }

        $silenceDurations = $this->audioServiceParser->parseFile($path);

        $chapters = $this->audioService->convertSilenceIntervalsToChapters($silenceDurations, $silenceChapterDuration, $maxSegmentDuration, $silenceSegmentDuration);
        $answerJson = $this->chapterConverter->convertToJson($chapters);

        $outputFile = $this->fileService->filePath('output.json');
        file_put_contents($outputFile, json_encode($answerJson, JSON_PRETTY_PRINT));
    }
}
