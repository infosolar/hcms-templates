<?php

declare(strict_types=1);

namespace App\Hcms\src\Exceptions;

use Exception;

class UnableToDeleteTemplateException extends Exception
{
    const MESSAGE = "Template already in use";
    const CODE = 403;

    public function __construct()
    {
        parent::__construct(self::MESSAGE, self::CODE);
    }
}
