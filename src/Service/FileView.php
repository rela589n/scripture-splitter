<?php

declare(strict_types=1);

namespace App\Service;

interface FileView
{
    public function getFileName(): string;

    public function getContent(): string;
}
