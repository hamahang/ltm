<div class="F" data-popup="tooltip" data-placement="bottom" data-html="true" data-original-title="ایجاد کننده<br /><br />{!! $data['F']->full_name !!}<br />{!! $data['F']->username !!}">
    <a href="{!! $data['F']->url !!}" target="_blank"><img src="{!! $data['F']->avatar_image !!}" /></a>
</div>
<div class="connector-indirect"></div>
<div class="P" data-popup="tooltip" data-placement="bottom" data-html="true" data-original-title="ارجاع دهنده<br /><br />{!! $data['P']->full_name !!}<br />{!! $data['P']->username !!}">
    <a href="{!! $data['P']->url !!}" target="_blank"><img src="{!! $data['P']->avatar_image !!}" /></a>
</div>
<div class="connector-direct"></div>
<div class="M" data-popup="tooltip" data-placement="bottom" data-html="true" data-original-title="مسئول (من)<br /><br />{!! $data['M']->full_name !!}<br />{!! $data['M']->username !!}">
    <a href="{!! $data['M']->url !!}" target="_blank"><img src="{!! $data['M']->avatar_image !!}" /></a>
</div>
<br />

<div class="F f-name">{!! $data['F']->full_name !!}</div>
<div class="connector-indirect connector-name"></div>
<div class="P p-name">{!! $data['P']->full_name !!}</div>
<div class="connector-direct connector-name"></div>
<div class="M m-name">{!! $data['M']->full_name !!}</div>
