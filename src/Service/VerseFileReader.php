<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Config\FileLocator;

final readonly class VerseFileReader
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/var/storage/')]
        private string $storageDir,
        private FileLocator $fileLocator,
        private Filesystem $filesystem,
    ) {
    }

    public function read(string $inputFileName): string
    {
        $filePath = $this->fileLocator->locate($this->storageDir.$inputFileName);

        return $this->filesystem->readFile($filePath);
    }
}
