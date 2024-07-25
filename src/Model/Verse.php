<?php

declare(strict_types=1);

namespace App\Model;

final readonly class Verse
{
    private const ANCHOR_LENGTH = 6;

    private string $anchor;

    public function __construct(
        private int $number,
        private string $text,
    ) {
        $this->anchor = mb_substr(sha1($this->text), 0, self::ANCHOR_LENGTH);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAnchor(): string
    {
        return $this->anchor;
    }
}
