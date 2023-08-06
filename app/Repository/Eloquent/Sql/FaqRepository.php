<?php

namespace App\Repository\Eloquent\Sql;

use App\Models\Faq;
use App\Repository\Contracts\IFaqRepository;

class FaqRepository extends BaseRepository implements IFaqRepository
{
    public function __construct(Faq $model)
    {
        parent::__construct($model);
    }
}
