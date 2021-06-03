<?php

namespace App\Service;

use App\Model\Chapter;
use App\Service\ServiceInterface\JsonChapterConverterInterface;

class JsonChapterConverter implements JsonChapterConverterInterface
{
    /**
     * @param Chapter[] $chapters
     *
     * @return string
     */
    public function convert(array $chapters): string
    {
        $prepareJson = [];
        foreach ($chapters as $chapterIndex => $chapter) {
            $chapterSegments = $chapter->getSegments();

            foreach ($chapterSegments as $segmentIndex => $chapterSegment) {
                $title = sprintf('Chapter %s, part %s', $chapterIndex + 1, $segmentIndex + 1);
                $offset = $chapterSegment->getStartDuration();
                $prepareJson[] = [
                    'title' => $title,
                    'offset' => $offset ? $offset->spec() : false,
                ];
            }
        }

        return json_encode($prepareJson, JSON_PRETTY_PRINT);
    }
}
