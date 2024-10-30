<?php

declare(strict_types=1);

namespace App\Hcms\src\Contracts;

use Meilisearch\Endpoints\Indexes;

interface IndexInterface
{
    public function use(): Indexes;

    public function resourceAttrForRetrieve(): array;

    public function attributesToHighlight(): array;

    public function drop(int $id): void;

    public function add(IndexableInterface $model): void;
}