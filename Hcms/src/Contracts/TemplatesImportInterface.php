<?php

declare(strict_types=1);

namespace App\Hcms\src\Contracts;

interface TemplatesImportInterface
{
    public function execute(): array;
}