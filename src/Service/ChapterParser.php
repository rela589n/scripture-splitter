<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Chapter;
use App\Model\Verse;

final readonly class ChapterParser
{
    public function parse(string $chapterReference, string $inputText): Chapter
    {
        $chapter = Chapter::create($chapterReference);

        $pattern = '/(\d+)(\D+)/u';
        preg_match_all($pattern, $inputText, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $number = $match[1];
            $text = trim($match[2]);

            Verse::create($chapter, (int)$number, $text);
        }

        return $chapter;
    }
}
