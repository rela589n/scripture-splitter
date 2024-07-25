<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\VerseDescriptor;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Config\FileLocator;

final readonly class VerseFileWriter
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/var/storage/')]
        private string $storageDir,
        private FileLocator $fileLocator,
        private Filesystem $filesystem,
    ) {
    }

    /** @param list<VerseDescriptor> $descriptors */
    public function write(string $outputDirName, array $descriptors): void
    {
        $storageDirectory = $this->fileLocator->locate($this->storageDir);

        $outputDirectory = $storageDirectory.$outputDirName;

        $this->filesystem->remove($outputDirectory);

        foreach ($descriptors as $descriptor) {
            $this->filesystem->dumpFile(
                $outputDirectory.$descriptor->getFileName(),
                $descriptor->getContent(),
            );
        }
    }
}
