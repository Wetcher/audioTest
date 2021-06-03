<?php

namespace App\Service;

use App\Model\TimePeriod;
use App\Service\ServiceInterface\XmlAudioSilenceParserInterface;
use App\Service\ServiceInterface\FileServiceInterface;
use Carbon\CarbonInterval;
use Exception;

class XmlAudioSilenceSilenceParser implements XmlAudioSilenceParserInterface
{
    /**
     * @var FileServiceInterface
     */
    private FileServiceInterface $fileService;

    /**
     * AudioSilenceParser constructor.
     *
     * @param FileServiceInterface $fileService
     */
    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param string $path
     *
     * @return TimePeriod[]
     */
    public function parseFile(string $path): array
    {
        $fullPath = $this->fileService->filePath($path);

        if (!$this->fileService->checkIfExists($fullPath)) {
            throw new Exception(sprintf('File "%s" is not found', $fullPath));
        }

        $parsedFile = simplexml_load_string(file_get_contents($fullPath));

        $silenceDurations = [];
        foreach ($parsedFile->children() as $parsedItem) {
            $from = CarbonInterval::fromString((string)$parsedItem['from']);
            $until = CarbonInterval::fromString((string)$parsedItem['until']);
            $silenceDurations[] = new TimePeriod($from, $until);
        }

        return $silenceDurations;
    }
}
