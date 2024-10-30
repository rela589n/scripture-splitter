<?php

declare(strict_types=1);

namespace App\Model\Epistle;

use App\Model\Epistle\Chapter\Chapter;
use App\Model\Epistle\Chapter\ChapterRange;

final  class Epistle
{
    public function __construct(
        /** @var array<int,Chapter> */
        private array $chapters,
    ) {
    }

    public function getChapterRange(): ChapterRange
    {
        return new ChapterRange(
            $this->getFirstChapterNumber(),
            $this->getLastChapterNumber(),
        );
    }

    public function addChapter(Chapter $chapter): void
    {
        $this->chapters[$chapter->getNumber()] = $chapter;
    }

    public function getLastChapter(): Chapter
    {
        return $this->chapters[$this->getLastChapterNumber()];
    }

    /** @return array<int,Chapter> */
    public function getChapters(): array
    {
        return $this->chapters;
    }

    private function getFirstChapterNumber(): int
    {
        return array_key_first($this->chapters);
    }

    private function getLastChapterNumber(): int
    {
        return array_key_last($this->chapters);
    }

    public function getPreviousChapter(Chapter $chapter): ?Chapter
    {
        return $this->chapters[$chapter->getNumber() - 1] ?? null;
    }

    public function getNextChapter(Chapter $chapter): ?Chapter
    {
        return $this->chapters[$chapter->getNumber() + 1] ?? null;
    }
}