<?php

declare(strict_types=1);

namespace App\Hcms\src\Services;

use App\Hcms\src\Enums\FieldTypes;
use App\Hcms\src\Enums\TemplateTypes;
use App\Hcms\src\Http\Requests\TemplateRequest;
use App\Hcms\src\Jobs\TemplateIndexJob;
use App\Hcms\src\Models\FieldTemplate;
use App\Hcms\src\Models\Template;
use Illuminate\Support\Facades\DB;


class TemplateSaveService
{
    public function execute(TemplateRequest $request): ?Template
    {
        return DB::transaction(function () use ($request) {
            /** @var Template $template */
            $template = Template::updateOrCreate(
                [
                    'id' => $request->get('id'),
                ],
                [
                    "name" => $request->get('name'),
                    "description" => $request->get('description'),
                    'reference_name' => $request->get('reference_name'),
                    "type" => TemplateTypes::from($request->get('type', TemplateTypes::CONTENT->value)),
                ]
            );

            collect($request->get('field_templates'))
                ->each(function (array $data, int $index) use ($template) {
                    if (($data['template_id'] ?? null) !== $template->id
                        && isset($data['template_id'])) {
                        $template->fieldTemplates()
                            ->sync([$data['id'] => ['order' => $index]], false);
                        return;
                    }

                    $this->saveField($template, $data, $index, $template->id,);
                });

            TemplateIndexJob::dispatchAfterResponse($template);

            return $template;
        });
    }

    private function saveField(
        Template|FieldTemplate $template,
        array $data,
        int $index = 0,
        int $templateId = null,
    ): void {
        $fieldTemplate = FieldTemplate::query()
            ->updateOrCreate(
                ["id" => $data['id'] ?? null],
                [
                    'name' => $data['name'],
                    'type_name' => FieldTypes::from($data['type_name']),
                    'config' => $data['config'] ?? [],
                    'reference_name' => $data['reference_name'],
                    'template_id' => $templateId ?? $template->template_id,
                    'description' => $data['description'] ?? null,
                    'order' => $index,
                ]
            );

        collect($data['field_templates'] ?? [])
            ->each(fn (array $data, int $index) => $this->saveField($fieldTemplate, $data, $index));

        $template->fieldTemplates()
            ->sync([$fieldTemplate->id => ['order' => $index]], false);
    }
}
