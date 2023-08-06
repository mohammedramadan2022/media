<?php

namespace App\Models;

use App\Casts\Status;
use App\Http\Traits\FaqTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Faq extends Model
{
    use SoftDeletes, Translatable, FaqTrait;

    public int $cols = 5;

    public $translationModel = FaqTranslation::class;

    public $translationForeignKey = 'faq_id';

    public array $translatedAttributes = ['question', 'answer'];

    protected $casts = ['status' => Status::class];

    public array $fields = [
        ['name' => 'question', 'type' => 'text', 'trans' => 'back.form-question'],
        ['name' => 'answer', 'type' => 'textarea', 'trans' => 'back.form-answer'],
    ];
}
