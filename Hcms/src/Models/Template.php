<?php

declare(strict_types=1);

namespace App\Hcms\src\Models;

use App\Hcms\src\Contracts\IndexableInterface;
use App\Hcms\src\Enums\TemplateTypes;
use App\Hcms\src\Observers\TemplateObserver;
use App\Hcms\src\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id;
 * @property string uuid;
 * @property int content_template_id;
 * @property string name;
 * @property string reference_name;
 * @property bool is_global;
 * @property string type;
 */
#[ObservedBy(TemplateObserver::class)]
class Template extends Model implements IndexableInterface
{
    use HasFactory;
    use UsesUuid;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'reference_name',
        'type',
    ];
    protected $hidden = ['pivot'];

    protected $with = ['fieldTemplates'];

    protected $casts = [
        'type' => TemplateTypes::class,
    ];

    public function fieldTemplates(): BelongsToMany
    {
        return $this->belongsToMany(
            FieldTemplate::class,
            'template_field_template',
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
