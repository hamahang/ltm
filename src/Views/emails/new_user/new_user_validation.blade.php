<!doctype html>
<html>
<head>
</head>
<body style="font-family: Tahoma; direction: rtl;">
<div class="">
    <div style="width: 100%">
        <div style="text-align: center; background-color: #444444">
            <img width="190" height="80" src="https://freezones.hamahang-co.ir/assets/images/free_zone_logo.png" data-filename="logo.png" style="width: 190px;">
        </div>
        <div style="padding: 20px"></div>
        <span>جهت بازیابی کلمه عبور حساب کاربری خود در سامانه دبیرخانه شورای عالی مناطق آزاد تجاری صنعتی و ویژه اقتصادی روی لینک زیر کلیک نمایید:</span>
        <div style="padding: 10px"></div>
        <div style="text-align: center;">
            <div style="text-align: center; background-color: #449D44; font-size: 18px; width: 200px;">
                <a class="btn btn-lg btn-success" href="{{ url('/auth/verify/verifyUserEmail') . '/' . $info['confirmation_code'] }}" role="button">فعال‌سازی حساب کاربری</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>