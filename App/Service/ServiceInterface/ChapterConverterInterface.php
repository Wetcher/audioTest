<?php


namespace App\Service\ServiceInterface;


use App\Model\Chapter;

interface ChapterConverterInterface
{
    /**
     * @param Chapter[] $chapters
     *
     * @return array
     */
    public function convertToJson(array $chapters): array;
}
