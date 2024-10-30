<?php

namespace App\Command;

use App\Model\Epistle\Chapter\ChapterRange;
use App\Service\ChapterObsidianFormatter;
use App\Service\EpistleParser;
use App\Service\VerseFileWriter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: 'splitter:run-range',
    description: 'Run epistle splitter',
)]
class RunEpistleSplitterCommand extends Command
{
    public function __construct(
        private readonly EpistleParser $parser,
        private ChapterObsidianFormatter $formatter,
        private VerseFileWriter $writer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('bookRef', InputArgument::REQUIRED, 'Book reference, example: "Івана"')
            ->addOption('workDir', null, InputOption::VALUE_REQUIRED, 'Working directory')
            ->addOption('range', null, InputOption::VALUE_REQUIRED, 'Chapters range');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var string $bookReference */
        $bookReference = $input->getArgument('bookRef');
        Assert::notEmpty($bookReference);

        /** @var string $workDirName */
        $workDirName = $input->getOption('workDir');
        Assert::notEmpty($workDirName);

        /** @var array $chapterRangeArray */
        $chapterRangeArray = explode('-', $input->getOption('range'));
        $chapterRange = new ChapterRange((int)$chapterRangeArray[0], (int)$chapterRangeArray[1]);

        $epistle = $this->parser->parse($bookReference, $workDirName, $chapterRange);

        foreach ($epistle->getChapters() as $chapter) {
            $outputDirName = sprintf('%s%d/', $workDirName, $chapter->getNumber());

            $verseDescriptors = $this->formatter->format($chapter);

            $this->writer->write($outputDirName, $verseDescriptors);
        }

        $io->success('Files have been successfully written');

        return Command::SUCCESS;
    }
}
