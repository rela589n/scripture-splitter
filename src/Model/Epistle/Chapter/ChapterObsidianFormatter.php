<?php

declare(strict_types=1);

namespace App\Model\Epistle\Chapter;

use App\Model\Epistle\Chapter\Verse\View\VerseView;
use App\Model\Epistle\Chapter\View\ChapterView;
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
     * @return VerseView
     */
    public function format(Chapter $chapter): array
    {
        $descriptors = [];

        $verses = $chapter->getVerses();

        foreach ($verses as $verse) {
            $content = $this->twig->render('verse.md.twig', [
                'verse' => $verse,
                'previousVerse' => $verse->getPreviousVerse(),
                'nextVerse' => $verse->getNextVerse(),
            ]);

            $descriptors[] = new VerseView($verse, $content);
        }

        $passageContent = $this->twig->render('chapter.md.twig', [
            'chapter' => $chapter,
            'previousChapter' => $chapter->getPreviousChapter(),
            'nextChapter' => $chapter->getNextChapter(),
        ]);

        $descriptors[] = new ChapterView($chapter, $passageContent);

        return $descriptors;
    }
}
