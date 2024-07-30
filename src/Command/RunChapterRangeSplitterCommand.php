<?php

namespace App\Command;

use App\Service\ChapterRangeSplitter;
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
    description: 'Run chapter range splitter',
)]
class RunChapterRangeSplitterCommand extends Command
{
    public function __construct(private readonly ChapterRangeSplitter $splitter)
    {
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

        /** @var array $chapterRange */
        $chapterRange = explode('-', $input->getOption('range'));
        [$rangeStart, $rangeEnd] = $chapterRange;
        $chapterRange = [(int)$rangeStart, (int)$rangeEnd];
        Assert::lessThanEq($chapterRange[0], $chapterRange[1]);

        $this->splitter->run($bookReference, $workDirName, $chapterRange);

        $io->success('Files have been successfully written');

        return Command::SUCCESS;
    }
}
