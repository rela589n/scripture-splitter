<?php

declare(strict_types=1);

namespace App\Model\Epistle\Chapter;

use App\Model\Epistle\Chapter\Verse\Verse;
use App\Model\Epistle\Epistle;

final class Chapter
{
    private function __construct(
        private Epistle $epistle,
        private int $number,
        /** @var array<int,Verse> $verses */
        private array $verses,
    ) {
        $this->epistle->addChapter($this);
    }

    public static function parse(Epistle $epistle, int $number): Chapter
    {
        return new self($epistle, $number, []);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getPreviousVerse(Verse $verse): ?Verse
    {
        return $this->verses[$verse->getNumber() - 1] ?? null;
    }

    public function getNextVerse(Verse $verse): ?Verse
    {
        return $this->verses[$verse->getNumber() + 1] ?? null;
    }

    public function getReference(): string
    {
        return sprintf('%s %d', $this->epistle->getName(), $this->number);
    }

    public function addVerse(Verse $verse): void
    {
        $this->verses[$verse->getNumber()] = $verse;
    }

    /** @return array<int,Verse> */
    public function getVerses(): array
    {
        return $this->verses;
    }

    public function getFirstVerse(): Verse
    {
        return $this->verses[$this->getFirstVerseNumber()];
    }

    public function getFirstVerseNumber(): int
    {
        return array_key_first($this->verses);
    }

    public function getLastVerse(): Verse
    {
        return $this->verses[$this->getLastVerseNumber()];
    }

    public function getLastVerseNumber(): int
    {
        return array_key_last($this->verses);
    }

    public function getPreviousChapter(): ?self
    {
        return $this->epistle->getPreviousChapter($this);
    }

    public function getNextChapter(): ?self
    {
        return $this->epistle->getNextChapter($this);
    }
}
