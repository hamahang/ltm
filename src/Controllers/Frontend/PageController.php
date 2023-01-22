<?php

namespace Hamahang\LTM\Controllers\Frontend;

use Hamahang\LTM\Controllers\Controller;
use Hamahang\FAQ\Models\Faq;

class PageController extends Controller
{
    public function index()
    {
        return view('laravel_task_manager::frontend.home_page');
    }

    public function about()
    {
        return view('laravel_task_manager::frontend.pages.about');
    }

    public function contact()
    {
        return view('laravel_task_manager::frontend.pages.contact');
    }

    public function rules()
    {
        return view('laravel_task_manager::frontend.pages.rules');
    }

    public function faqs()
    {
        $faqs = '';
        return view('laravel_task_manager::frontend.pages.faqs')->with(compact('faqs'));
    }
}
