<?php

declare(strict_types=1);

namespace App\Model;

final class Chapter
{
    public function __construct(
        private readonly string $reference,
        /** @var array<int,Verse> $verses */
        private array $verses,
    ) {
    }

    public static function create(string $reference): Chapter
    {
        return new self($reference, []);
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
        return $this->reference;
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

    }

    public function getNextChapter(): ?self
    {

    }
}
