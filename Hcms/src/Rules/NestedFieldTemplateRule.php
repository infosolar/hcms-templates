<?php

declare(strict_types=1);

namespace App\Hcms\src\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class NestedFieldTemplateRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!$this->validateFieldTemplates($value)) {
            $fail('All required fields must be filled.');
        }
    }

    protected function validateFieldTemplates(array $fieldTemplates): bool
    {
        foreach ($fieldTemplates as $fieldTemplate) {
            if (!isset($fieldTemplate['name']) || (!is_string($fieldTemplate['name']))) {
                return false;
            }

            if (!isset($fieldTemplate['reference_name']) || (!is_string($fieldTemplate['reference_name']))) {
                return false;
            }

            if (isset($fieldTemplate['field_templates']) && is_array($fieldTemplate['field_templates'])) {
                if (!$this->validateFieldTemplates($fieldTemplate['field_templates'])) {
                    return false;
                }
            }
        }

        return true;
    }
}
