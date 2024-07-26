<?php

declare(strict_types=1);

namespace App\Service;

interface FileDescriptor
{
    public function getFileName(): string;

    public function getContent(): string;
}
