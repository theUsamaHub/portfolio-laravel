<?php

namespace App\Http\Controllers;

use App\Models\NavigationMenu;
use App\Models\SocialLink;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        View::share('navigation', NavigationMenu::active()->topLevel()->ordered()->with('children')->get());
        View::share('socialLinks', SocialLink::active()->ordered()->get());
    }
}
