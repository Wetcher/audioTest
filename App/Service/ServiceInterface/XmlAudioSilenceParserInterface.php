<?php

namespace App\Service\ServiceInterface;

use App\Model\TimePeriod;
use Exception;

interface XmlAudioSilenceParserInterface
{
    /**
     * @param string $path
     *
     * @return TimePeriod[]
     *
     * @throws Exception
     */
    public function parseFile(string $path): array;
}

