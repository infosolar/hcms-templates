<?php

namespace App\Hcms\src\Meilisearch;

use Meilisearch\Client;

class Meilisearch extends Client
{
    public function __construct()
    {
        parent::__construct(config('meilisearch.host'), config('meilisearch.key'));
    }
}