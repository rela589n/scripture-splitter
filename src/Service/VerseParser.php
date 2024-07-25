<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Verse;

final readonly class VerseParser
{
    /** @return Verse[] */
    public function parse(string $inputText): array
    {
        $verses = [];
        $pattern = '/(\d+)(\D+)/u';
        preg_match_all($pattern, $inputText, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $number = $match[1];
            $text = trim($match[2]);
            $verses[] = new Verse((int)$number, $text);
        }

        return $verses;
    }
}
