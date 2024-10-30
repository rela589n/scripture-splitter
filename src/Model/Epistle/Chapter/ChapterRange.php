<?php

declare(strict_types=1);

namespace App\Model\Epistle\Chapter;

use Webmozart\Assert\Assert;

final readonly class ChapterRange
{
    public function __construct(
        private int $startingChapterNumber,
        private int $endingChapterNumber,
    ) {
        Assert::greaterThan($this->startingChapterNumber, 0);
        Assert::lessThan($this->endingChapterNumber, 200);

        Assert::lessThanEq($this->startingChapterNumber, $this->endingChapterNumber);
    }

    public function getRange(): array
    {
        return range($this->startingChapterNumber, $this->endingChapterNumber);
    }
}
