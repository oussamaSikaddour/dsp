<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Service; // Make sure you have a Service model

class GuestController extends Controller
{

    public function showNewsPage(): View
    {

        $breadcrumbLinks = [
            ['route' => 'index',      'label' => __('pages.landing_page.name')],
            ['route' => 'news', 'label' => __('pages.news.name')]
        ];

        $title = __('pages.news.name');
        return view('pages.app.news', compact('title', 'breadcrumbLinks'));
    }



}
