<?php

declare(strict_types=1);

namespace  App\Hcms\src\Models;

use App\Hcms\src\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id;
 * @property int $template_id;
 * @property string $name;
 * @property string $type_name;
 * @property array $config;
 * @property array $reference_name;
 */
class FieldTemplate extends Model
{
    use HasFactory;
    use UsesUuid;

    public $timestamps = false;

    protected $hidden = ['pivot'];

    protected $fillable = [
        'name',
        'reference_name',
        'type_name',
        'config',
        'description',
        'template_id',
        'order',
    ];

    protected $casts = [
        "config" => 'array',
    ];

    protected $with = ['fieldTemplates'];

    public function fieldTemplates(): BelongsToMany
    {
        return $this->belongsToMany(
            FieldTemplate::class,
            'field_template_field_template',
            'template_id',
            'field_template_id',
            'id',
            'id'
        )
            ->withPivot("order")
            ->orderBy('pivot_order')
            ->with('fieldTemplates');
    }


}
