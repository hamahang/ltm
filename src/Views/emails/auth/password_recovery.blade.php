<!doctype html>
<html>
<head>
</head>
<body style="font-family: Tahoma; direction: rtl;">
<div class="">
    <div style="width: 100%">
        <div style="text-align: center; background-color: #444444">
            <img width="190" height="80" src="https://freezones.hamahang-co.ir/assets/images/imf_logo.jpg">
        </div>
        <div style="padding: 20px"></div>
        <span>جهت بازیابی کلمه عبور حساب کاربری خود در سامانه وزارت صنعت ،‌معدن و تجارت روی لینک زیر کلیک نمایید:</span>
        <div style="padding: 10px"></div>
        <div style="text-align: center;">
            <div style="text-align: center; background-color: #449D44; font-size: 18px; width: 200px;">
                <a class="btn btn-lg btn-success" href="{{ url('verifyEmailRecoveryCode') . '/' . $info['confirmation_code'] }}" role="button">فعال‌سازی حساب کاربری</a>
                {{--<a class="btn btn-lg btn-success" href="{{ url('verifyEmailRecoveryCode') . '/' . $info['confirmation_code'] }}" role="button">فعال‌سازی حساب کاربری</a>--}}
            </div>
        </div>
    </div>
</div>
</body>
</html>