<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\File\ChapterDescriptor;
use App\Model\File\VerseDescriptor;
use App\Model\Chapter;
use Twig\Environment;
use Twig\Error\Error;

final readonly class ChapterObsidianFormatter
{
    public function __construct(
        private Environment $twig,
    ) {
    }

    /**
     * @throws Error
     *
     * @return list<VerseDescriptor>
     */
    public function format(Chapter $chapter): array
    {
        $descriptors = [];

        $verses = $chapter->getVerses();

        foreach ($verses as $index => $verse) {
            $previousVerse = $verses[$index - 1] ?? null;
            $nextVerse = $verses[$index + 1] ?? null;

            $content = $this->twig->render('verse.md.twig', [
                'chapterReference' => $chapter->getReference(),
                'previousVerse' => $previousVerse,
                'verse' => $verse,
                'nextVerse' => $nextVerse,
            ]);

            $descriptors[] = new VerseDescriptor($verse, $content);
        }

        $passageContent = $this->twig->render('passage.md.twig', [
            'chapterReference' => $chapter->getReference(),
            'passage' => $chapter,
        ]);

        $descriptors[] = new ChapterDescriptor($chapter, $passageContent);

        return $descriptors;
    }
}
