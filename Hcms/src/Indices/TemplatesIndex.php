<?php

namespace App\Hcms\src\Indices;

use App\Hcms\src\Contracts\IndexableInterface;
use App\Hcms\src\Contracts\IndexInterface;
use App\Hcms\src\Meilisearch\Meilisearch;
use Meilisearch\Endpoints\Indexes;

class TemplatesIndex extends Meilisearch implements IndexInterface
{
    const INDEX_NAME = 'entities-templates';

    const SEARCHABLE_FIELDS = [
        'id',
        'type',
        'name',
    ];

    public function add(IndexableInterface $model): void
    {
        $this->index(self::INDEX_NAME)
            ->addDocuments([$model->toArray()]);
    }

    public function drop(int $id): void
    {
        $this->index(self::INDEX_NAME)
            ->deleteDocument($id);
    }

    function use(): Indexes
    {
        return $this->index(self::INDEX_NAME);
    }

    public function resourceAttrForRetrieve(): array
    {
        return [
            'id',
            'type',
            'name',
        ];
    }

    public function attributesToHighlight(): array
    {
        return [];
    }
}