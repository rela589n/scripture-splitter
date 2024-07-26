<?php

declare(strict_types=1);

namespace App\Model;

final readonly class Passage
{
    public function __construct(
        /** @var list<Verse> $verses */
        private array $verses,
    ) {
    }

    /** @return list<Verse> */
    public function getVerses(): array
    {
        return $this->verses;
    }

    public function getStartVerseNumber(): int
    {
        return $this->verses[0]->getNumber();
    }

    public function getEndVerseNumber(): int
    {
        return $this->verses[count($this->verses) - 1]->getNumber();
    }
}
