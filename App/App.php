<?php

namespace App;

use App\Commands\ConvertSilencesIntoChaptersCommand;
use App\Service\AudioService;
use App\Service\ChapterService;
use App\Service\FileService;
use App\Service\JsonChapterConverter;
use App\Service\SilenceService;
use App\Service\XmlAudioSilenceSilenceParser;

class App
{
    /**
     * @var string
     */
    private string $basePath;

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
     * @param array $params
     * @throws \Exception
     */
    public function run(array $params): void
    {
        $fileService = new FileService($this->basePath);
        $chapterConverter = new JsonChapterConverter();
        $audioSilenceParser = new XmlAudioSilenceSilenceParser($fileService);

        $chapterService = new ChapterService();
        $silenceService = new SilenceService();
        $audioService = new AudioService($silenceService, $chapterService);

        $command = new ConvertSilencesIntoChaptersCommand($fileService, $audioSilenceParser, $chapterConverter, $audioService);
        $command->execute($params);
    }
}
