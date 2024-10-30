<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Epistle\Chapter\ChapterRange;
use App\Model\Epistle\Epistle;

final readonly class EpistleParser
{
    public function __construct(
        private ChapterParser $chapterParser,
    ) {
    }

    public function parse(string $bookReference, string $workDirName, ChapterRange $chapterRange): Epistle
    {
        $epistle = new Epistle([]);

        foreach ($chapterRange->getRange() as $chapterNumber) {
            $inputFileName = sprintf('%s%d.txt', $workDirName, $chapterNumber);
            $chapterReference = sprintf('%s %d', $bookReference, $chapterNumber);

            $this->chapterParser->parse($epistle, $chapterNumber, $chapterReference, $inputFileName);
        }

        return $epistle;
    }
}
