@php
    $front_settings = []; //front_settings()
@endphp
<footer id="footer_area" style="background-color: #114152; padding: 10px 20px; border-top:4px solid #8a9ba0; color: #93a4ab">
    <div class="container" style="position: relative">
        <div class="row">
            <div class="col-sm-4">
                <fieldset>
                    <legend style="color: #809299; font-size: 16px; font-weight: bold;">{{ @$front_settings['footer']->right_section->title }}</legend>
                    <div style="font-size: 14px; line-height: 25px; text-align: justify;">
                        <p>{!! @$front_settings['footer']->right_section->text !!}</p>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-4">
                <fieldset>
                    <legend style="color: #809299; font-size: 16px; font-weight: bold;">{{ @$front_settings['footer']->middle_section->title }}</legend>
                    <div style="font-size: 14px; line-height: 25px; text-align: justify;">
                        {!! @$front_settings['footer']->middle_section->text !!}
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-4" style="min-height: 150px; background-color: #18495a; padding-top: 15px">
                {!! @$front_settings['footer']->left_section->text !!}
            </div>
        </div>
    </div>
</footer>
<div id="copyright" style="background-color: #062f3e; padding: 5px 10px; width: 100%; color: #eee;">
    <div class="container">
        <div class="text-center">
            <span>{!!  @$front_settings['footer']->copyright !!}</span>
        </div>
    </div>
</div>