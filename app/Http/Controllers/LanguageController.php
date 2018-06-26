<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
class LanguageController extends Controller
{
    public function __invoke(Request $request, $locale){
        return redirect('/')->withCookie(cookie()->forever('language', $locale));
    }
}
