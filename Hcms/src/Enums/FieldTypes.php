<?php

declare(strict_types=1);

namespace App\Hcms\src\Enums;

enum FieldTypes: string
{
    case TEXT = "text";
    case RICH_TEXT = "rich-text";
    case BOOLEAN = "boolean";
    case IMAGE = "image";
    case FILE = "file";
    case REPEATER = "repeater";
    case FRAME = "frame";
    case CONTENT = "content";
    case CONTENT_DATE = "date-time";
    case DICTIONARY = "dictionary";
    case VALUE = "value";
}
