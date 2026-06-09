<?php

namespace App\Controllers;

use Config\App;

class Language extends BaseController
{
    public function index(string $locale)
    {
        if (in_array($locale, config(App::class)->supportedLocales, true)) {
            session()->set('locale', $locale);
        }

        return redirect()->back();
    }
}
