<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PARENT_API extends Controller
{
    public string $lang;

    public function __construct(Request $request)
    {
        $lang = (string) lower($request->header('lang'));

        $this->lang = ($lang) ? (($lang == 'ar') ? $lang : 'en') : 'en';

        app()->setLocale($this->lang);

        carbon()->setLocale($this->lang);
    }
}
