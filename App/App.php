<?php

namespace App;

use App\Commands\ConvertSilencesIntoChaptersCommand;
use App\Service\AudioService;
use App\Service\AudioSilenceParser;
use App\Service\ChapterConverter;
use App\Service\ChapterService;
use App\Service\FileService;
use App\Service\SilenceService;

class App
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * App constructor.
     *
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $params = getopt('', [
            "path:",
            "silence-chapter-duration:",
            "max-segment-duration:",
            "silence-segment-duration:",
        ]);

        $fileService = new FileService($this->basePath);
        $chapterConverter = new ChapterConverter();
        $audioSilenceParser = new AudioSilenceParser($fileService);

        $chapterService = new ChapterService();
        $silenceService = new SilenceService();
        $audioService = new AudioService($silenceService, $chapterService);

        $command = new ConvertSilencesIntoChaptersCommand($fileService, $audioSilenceParser, $chapterConverter, $audioService);
        $command->execute($params);
    }
}
