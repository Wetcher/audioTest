<?php

namespace App\Commands;

use App\Service\ServiceInterface\AudioServiceInterface;
use App\Service\ServiceInterface\FileServiceInterface;
use App\Service\ServiceInterface\JsonChapterConverterInterface;
use App\Service\ServiceInterface\XmlAudioSilenceParserInterface;
use Carbon\CarbonInterval;
use Exception;

class ConvertSilencesIntoChaptersCommand extends AbstractCommand
{
    protected array $requiredOptions = [
        "path",
        "silence-chapter-duration",
        "max-segment-duration",
        "silence-segment-duration",
    ];

    /**
     * @var XmlAudioSilenceParserInterface
     */
    private XmlAudioSilenceParserInterface $audioServiceParser;

    /**
     * @var JsonChapterConverterInterface
     */
    private JsonChapterConverterInterface $chapterConverter;

    /**
     * @var AudioServiceInterface
     */
    private AudioServiceInterface $audioService;

    /**
     * @var FileServiceInterface
     */
    private FileServiceInterface $fileService;

    /**
     * ConvertSilencesIntoChaptersCommand constructor.
     *
     * @param FileServiceInterface $fileService
     * @param XmlAudioSilenceParserInterface $audioServiceParser
     * @param JsonChapterConverterInterface $chapterConverter
     * @param AudioServiceInterface $audioService
     */
    public function __construct(FileServiceInterface $fileService, XmlAudioSilenceParserInterface $audioServiceParser, JsonChapterConverterInterface $chapterConverter, AudioServiceInterface $audioService)
    {
        $this->fileService = $fileService;
        $this->audioServiceParser = $audioServiceParser;
        $this->chapterConverter = $chapterConverter;
        $this->audioService = $audioService;
    }

    /**
     * @param array $arguments
     *
     * @throws Exception
     */
    protected function doExecute(array $arguments): void
    {
        $path = $arguments['path'];
        $silenceChapterDuration = CarbonInterval::fromString(($arguments['silence-chapter-duration']))->total('milliseconds');
        $maxSegmentDuration = CarbonInterval::fromString($arguments['max-segment-duration'])->total('milliseconds');
        $silenceSegmentDuration = CarbonInterval::fromString($arguments['silence-segment-duration'])->total('milliseconds');

        if ($silenceChapterDuration <= $silenceSegmentDuration) {
            throw new Exception('Segment chapter silence duration is greater then chapter silence duration');
        }

        $silenceDurations = $this->audioServiceParser->parseFile($path);

        $chapters = $this->audioService->convertSilenceIntervalsToChapters($silenceDurations, $silenceChapterDuration, $maxSegmentDuration, $silenceSegmentDuration);
        $answerJson = $this->chapterConverter->convert($chapters);

        $outputFile = $this->fileService->filePath('output.json');
        file_put_contents($outputFile, $answerJson);
    }
}
