<?php

declare(strict_types=1);

namespace  App\Hcms\src\Services;


use App\Hcms\src\Indices\TemplatesIndex;
use App\Hcms\src\Factories\PaginatorView;
use Illuminate\Http\Request;


class TemplateSearchService
{
    public function __construct(
        readonly private TemplatesIndex $contentTemplateIndex,
        readonly private PaginatorView $paginatorView
    ) {}

    public function execute(Request $request): array
    {
        $filter = collect($request->get('type', []))
            ->map(fn (string $type) => "type=$type")
            ->toArray();

        $result = $this->contentTemplateIndex->use()
            ->search($request->get('query'), [
                'hitsPerPage' => $request->integer('limit', 15),
                'page' => $request->integer('page', 1),
                'filter' => [$filter],
            ]);

        return $this->paginatorView->from($result);
    }
}
