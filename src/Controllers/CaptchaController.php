<?php

namespace Hamahang\LTM\Controllers;

use Intervention\Image\Facades\Image;

class CaptchaController extends Controller
{
    public function Index($section)
    {
        if (!in_array($section, config('captcha.available_sections')))
        {
            abort(403);
        }
        $color = config('captcha.color');
        $width = config('captcha.width');
        $height = config('captcha.height');
        $length = config('captcha.length');
        $quality = config('captcha.quality');

        $random_string = str_replace('O', '7', strtoupper(md5(rand(0, 1000000))));
        $random_string = str_replace('0', 'H', $random_string);
        $random_string = str_replace('B', 'F', $random_string);
        $random_string = str_replace('8', '9', $random_string);
        $random_string = str_replace('2', '4', $random_string);
        $random_string = str_replace('Z', 'K', $random_string);
        $random_string = str_replace('S', 'P', $random_string);
        $random_string = str_replace('5', 'E', $random_string);
        $random_string = str_replace('6', 'X', $random_string);
        $random_string = str_replace('G', '7', $random_string);
        $random_string = str_replace('1', 'R', $random_string);
        $random_string = str_replace('I', 'U', $random_string);
        $captcha = strtoupper(substr($random_string, rand(0, 3), $length));
        session()->put('captcha_' . $section, $captcha);
        $im = imagecreatetruecolor($width, $height);
        switch (rand(0, 4))
        {
            case 0:
                $color = imagecolorallocate($im, 34, 155, 91);
                break;
            case 1:
                $color = imagecolorallocate($im, 233, 26, 74);
                break;
            case 2:
                $color = imagecolorallocate($im, 233, 26, 195);
                break;
            case 3:
                $color = imagecolorallocate($im, 244, 178, 19);
                break;
            case 4:
                $color = imagecolorallocate($im, 53, 125, 199);
                break;
        }
        //$white = imagecolorallocate($im, 255, 255, 255);
        //pick a random color for the text
        $x = 20;
        $y = 47;//the starting position for drawing
        for ($i = 0; $i < $length; $i++)
        {
            $angle = rand(-8, 8) + rand(0, 9) / 10;
            $fontsize = rand(22, 32);//pick a random font size
            $letter = substr($captcha, $i, 1);
            imagealphablending($im, true);
            $font = public_path(config('captcha.CAPTCHA_FONT_ADDRESS'));
            $coords = imagettftext($im, $fontsize, $angle, $x, $y, $color, $font, $letter);
            //draw each letter
            $x += ($coords[2] - $x) + 1;
        }
//        imagecolorallocate($im, 255, 255, 255);
        $img = Image::make($im);
//        $img->colorize(30, 30, 30);
        return $img->response('jpg', $quality);
    }
}
