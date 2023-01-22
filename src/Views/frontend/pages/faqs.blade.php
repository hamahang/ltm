@extends('laravel_task_manager::layouts.frontend.bootstrap_v4.master')

@section('title', 'ثبت نام')
@section('content')
    <script src="{{ asset('vendor/laravel_faq/components/faq_b_4.min.js') }}" defer></script>
    <div>
        <div id="faq_temp">
            <laravel_faq lang_id=1 :rtl=true></laravel_faq>
        </div>
    </div>
@stop