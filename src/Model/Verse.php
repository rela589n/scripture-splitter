<?php

declare(strict_types=1);

namespace App\Model;

final readonly class Verse
{
    private const ANCHOR_LENGTH = 6;

    private string $anchor;

    public function __construct(
        private Chapter $chapter,
        private int $number,
        private string $text,
    ) {
        $this->anchor = mb_substr(sha1($this->text), 0, self::ANCHOR_LENGTH);
        $this->chapter->addVerse($this);
    }

    public static function create(Chapter $chapter, int $number, string $text): self
    {
        return new self($chapter, $number, $text);
    }

    public function getPreviousVerse(): ?self
    {
        return $this->chapter->getPreviousVerse($this)
            ?? $this->chapter->getPreviousChapter()?->getLastVerse();
    }

    public function getNextVerse(): ?self
    {
        return $this->chapter->getNextVerse($this)
            ?? $this->chapter->getNextChapter()?->getFirstVerse();
    }

    public function getChapter(): Chapter
    {
        return $this->chapter;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    /** @api */
    public function getText(): string
    {
        return $this->text;
    }

    /** @api */
    public function getAnchor(): string
    {
        return $this->anchor;
    }
}
