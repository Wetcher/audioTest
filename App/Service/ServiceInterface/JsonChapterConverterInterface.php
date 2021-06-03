<?php


namespace App\Service\ServiceInterface;


use App\Model\Chapter;

interface JsonChapterConverterInterface
{
    /**
     * @param Chapter[] $chapters
     *
     * @return string
     */
    public function convertToJson(array $chapters): string;
}
