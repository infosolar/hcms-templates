<?php

declare(strict_types=1);

namespace App\Hcms\src\Http\Requests;

use App\Hcms\src\Rules\NestedFieldTemplateRule;
use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => 'required',
            'field_templates' => ['required', 'array', new NestedFieldTemplateRule()],
        ];
    }
}
