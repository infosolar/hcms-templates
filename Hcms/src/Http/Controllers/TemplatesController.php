<?php

declare(strict_types=1);

namespace App\Hcms\src\Http\Controllers;

use App\Hcms\src\Exceptions\UnableToDeleteTemplateException;
use App\Hcms\src\Http\Requests\TemplateRequest;
use App\Hcms\src\Services\TemplateDestroyFieldService;
use App\Hcms\src\Services\TemplateDestroyService;
use App\Hcms\src\Services\TemplateSaveService;
use App\Hcms\src\Services\TemplateSearchService;
use App\Hcms\src\Services\TemplateShowService;
use App\Http\Controllers\Controller;
use App\Response\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{

    public function __construct(
        private readonly Response $response,
        private readonly TemplateSaveService $contentTemplateSaveService,
        private readonly TemplateSearchService $contentTemplateSearchService,
        private readonly TemplateShowService $contentTemplateShowService,
        private readonly TemplateDestroyFieldService $contentTemplateItemDestroyService,
        private readonly TemplateDestroyService $contentTemplateDeleteService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        return $this->response->ok($this->contentTemplateSearchService->execute($request));
    }

    public function store(TemplateRequest $request): JsonResponse
    {
        return $this->response->created($this->contentTemplateSaveService->execute($request));
    }

    public function show(int $id): JsonResponse
    {
        return $this->response->ok($this->contentTemplateShowService->execute($id));
    }

    public function update(TemplateRequest $request): JsonResponse
    {
        return $this->response->ok($this->contentTemplateSaveService->execute($request));
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->contentTemplateDeleteService->execute($id);
            return $this->response->deleted();
        } catch (UnableToDeleteTemplateException $exception) {
            return $this->response->error($exception->getMessage());
        }
    }

    public function destroyField(Request $request): JsonResponse
    {
        $this->contentTemplateItemDestroyService->execute($request);
        return $this->response->deleted();
    }

}
