<?php

declare(strict_types=1);

namespace App\Hcms\src\Jobs;

use App\Hcms\src\Indices\TemplatesIndex;
use App\Hcms\src\Models\Template;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TemplateIndexJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Template $template) {}

    public function handle(TemplatesIndex $index): void
    {
        $this->template->load('fieldTemplates');
        $index->add($this->template);
    }
}
