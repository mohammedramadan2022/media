<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\Other\HasImage;
use App\Http\Traits\PreviewTrait;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Preview extends Model
{
    use SoftDeletes, PreviewTrait, HasImage;

    public int $cols = 5;

    protected $guarded = ['id'];

    protected $casts = ['status' => Status::class];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
