<?php

declare(strict_types=1);

namespace App\Model\Epistle;

use App\Model\Epistle\Chapter\ChapterParser;
use App\Model\Epistle\Chapter\ChapterRange;

final readonly class EpistleParser
{
    public function __construct(
        private ChapterParser $chapterParser,
    ) {
    }

    public function parse(string $epistleName, string $translationName, string $workDirName, ChapterRange $chapterRange): Epistle
    {
        $epistle = new Epistle($epistleName, $translationName, []);

        foreach ($chapterRange->getRange() as $chapterNumber) {
            $inputFileName = sprintf('%s%d.txt', $workDirName, $chapterNumber);

            $this->chapterParser->parse($epistle, $chapterNumber, $inputFileName);
        }

        return $epistle;
    }
}
