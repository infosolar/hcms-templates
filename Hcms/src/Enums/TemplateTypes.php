<?php

declare(strict_types=1);

namespace App\Hcms\src\Enums;

enum TemplateTypes: string
{
    case CONTENT = "content";
    case VALUE = "value";
    case GLOBAL = "global";
}
