<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\{Rate, Token};

trait HasIsRated
{
    public function isRated(): Attribute
    {
        return Attribute::get(function(){
            $is_rated = false;

            if (getTokenable() != '')
            {
                if (! $user = Token::whereJwt(getTokenable())->first()) return false;

                $query = Rate::query();

                $query->where('rateable_type', self::class);

                $query->where('user_id', $user->tokenable_id ?? 0);

                $query->where('rateable_id', $this->id);

                $check = $query->first();

                if ($check) $is_rated = true;
            }

            return $is_rated;
        });
    }
}
