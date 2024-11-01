<?php

declare(strict_types=1);

namespace App\Model\Epistle\Chapter\Verse;

use App\Model\Epistle\Chapter\Chapter;

final readonly class ChapterVersesParser
{
    public function parse(Chapter $chapter, string $inputText): void
    {
        $pattern = '/(\d+)(\D+)/u';
        preg_match_all($pattern, $inputText, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $number = $match[1];
            $text = trim($match[2]);

            Verse::create($chapter, (int)$number, $text);
        }
    }
}
