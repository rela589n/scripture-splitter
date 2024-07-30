<?php

declare(strict_types=1);

namespace App\Service;

final readonly class ChapterRangeSplitter
{
    public function __construct(
        private ChapterSplitter $chapterSplitter,
    ) {
    }

    public function run(string $bookReference, string $workDirName, array $chapterRange): void
    {
        foreach (range(...$chapterRange) as $chapterNo) {
            $inputFileName = sprintf('%s%d.txt', $workDirName, $chapterNo);
            $chapterReference = sprintf('%s %d', $bookReference, $chapterNo);
            $outputDirName = sprintf('%s%d/', $workDirName, $chapterNo);

            $this->chapterSplitter->run($inputFileName, $chapterReference, $outputDirName);
        }
    }
}
