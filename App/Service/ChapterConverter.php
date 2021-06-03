<?php

namespace App\Service;

use App\Model\Chapter;
use App\Service\ServiceInterface\ChapterConverterInterface;

class ChapterConverter implements ChapterConverterInterface
{
    /**
     * @param Chapter[] $chapters
     *
     * @return array
     */
    public function convertToJson(array $chapters): array
    {
        $json = [];
        foreach ($chapters as $chapterIndex => $chapter) {
            $chapterSegments = $chapter->getSegments();

            foreach ($chapterSegments as $segmentIndex => $chapterSegment) {
                $title = sprintf('Chapter %s, part %s', $chapterIndex + 1, $segmentIndex + 1);
                $offset = $chapterSegment->getStartDuration();
                $json[] = [
                    'title' => $title,
                    'offset' => $offset ? $offset->spec() : false,
                ];
            }
        }

        return $json;
    }
}
