<?php

if (!function_exists('ltm_generate_location_picker_modal'))
{
    function ltm_generate_location_picker_modal($modal_id, $lat_input_id, $long_input_id, $map_area_id = 'map_area_id', $input_address = 'input_address', $btn_title = 'انتخاب موقعیت مکانی', $modal_title = 'انتخاب موقعیت مکان مورد نظر :', $map_area_width = '100%', $map_area_height = '420px', $marker_radius = 20)
    {
        $res['btn_open_modal'] = '<button class="btn btn-light" data-target="#' . $modal_id . '" data-toggle="modal" type="button"><i class="fa fa-map-marker"></i> ' . $btn_title . '</button>';
        $res['modal_content'] = view('common.location_picker', compact('modal_id', 'btn_title', 'modal_title', 'lat_input_id', 'long_input_id', 'map_area_id', 'input_address', 'map_area_width', 'map_area_height', 'marker_radius'))->render();

        return $res;
    }
}

//-----------------------------------------   Minify HTML Output -----------------------------------------//
if (!function_exists('ltm_minify_css'))
{
    function ltm_minify_css($input)
    {
        if (trim($input) === "")
        {
            return $input;
        }

        return preg_replace(
            [
                // Remove comment(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                // Remove unused white-space(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                // Replace `:0 0 0 0` with `:0`
                '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                // Replace `background-position:0` with `background-position:0 0`
                '#(background-position):0(?=[;\}])#si',
                // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
                '#(?<=[\s:,\-])0+\.(\d+)#s',
                // Minify string value
                '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
                '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                // Minify HEX color code
                '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                // Replace `(border|outline):none` with `(border|outline):0`
                '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                // Remove empty selector(s)
                '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
            ],
            [
                '$1',
                '$1$2$3$4$5$6$7',
                '$1',
                ':0',
                '$1:0 0',
                '.$1',
                '$1$3',
                '$1$2$4$5',
                '$1$2$3',
                '$1:0',
                '$1$2'
            ],
            $input);
    }
}

if (!function_exists('ltm_minify_js'))
{
    function ltm_minify_js($input)
    {
        if (trim($input) === "")
        {
            return $input;
        }

        return preg_replace(
            [
                // Remove comment(s)
                '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
                // Remove white-space(s) outside the string and regex
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
                // Remove the last semicolon
                '#;+\}#',
                // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
                '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
                // --ibid. From `foo['bar']` to `foo.bar`
                '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
            ],
            [
                '$1',
                '$1$2',
                '}',
                '$1$3',
                '$1.$3'
            ],
            $input);
    }
}

if (!function_exists('ltm_minify_html'))
{
    function ltm_minify_html($input)
    {
        if (trim($input) === "")
        {
            return $input;
        }
        // Remove extra white-space(s) between HTML attribute(s)
        $input = preg_replace_callback('#<([^\/\s<>!]+)(?:\s+([^<>]*?)\s*|\s*)(\/?)>#s', function ($matches)
        {
            return '<' . $matches[1] . preg_replace('#([^\s=]+)(\=([\'"]?)(.*?)\3)?(\s+|$)#s', ' $1$2', $matches[2]) . $matches[3] . '>';
        }, str_replace("\r", "", $input));
        // Minify inline CSS declaration(s)
        if (strpos($input, ' style=') !== false)
        {
            $input = preg_replace_callback('#<([^<]+?)\s+style=([\'"])(.*?)\2(?=[\/\s>])#s', function ($matches)
            {
                return '<' . $matches[1] . ' style=' . $matches[2] . ltm_minify_css($matches[3]) . $matches[2];
            }, $input);
        }
        if (strpos($input, '</style>') !== false)
        {
            $input = preg_replace_callback('#<style(.*?)>(.*?)</style>#is', function ($matches)
            {
                return '<style' . $matches[1] . '>' . ltm_minify_css($matches[2]) . '</style>';
            }, $input);
        }
        if (strpos($input, '</script>') !== false)
        {
            $input = preg_replace_callback('#<script(.*?)>(.*?)</script>#is', function ($matches)
            {
                return '<script' . $matches[1] . '>' . ltm_minify_js($matches[2]) . '</script>';
            }, $input);
        }

        return preg_replace(
            [
                // t = text
                // o = tag open
                // c = tag close
                // Keep important white-space(s) after self-closing HTML tag(s)
                '#<(img|input)(>| .*?>)#s',
                // Remove a line break and two or more white-space(s) between tag(s)
                '#(<!--.*?-->)|(>)(?:\n*|\s{2,})(<)|^\s*|\s*$#s',
                '#(<!--.*?-->)|(?<!\>)\s+(<\/.*?>)|(<[^\/]*?>)\s+(?!\<)#s', // t+c || o+t
                '#(<!--.*?-->)|(<[^\/]*?>)\s+(<[^\/]*?>)|(<\/.*?>)\s+(<\/.*?>)#s', // o+o || c+c
                '#(<!--.*?-->)|(<\/.*?>)\s+(\s)(?!\<)|(?<!\>)\s+(\s)(<[^\/]*?\/?>)|(<[^\/]*?\/?>)\s+(\s)(?!\<)#s', // c+t || t+o || o+t -- separated by long white-space(s)
                '#(<!--.*?-->)|(<[^\/]*?>)\s+(<\/.*?>)#s', // empty tag
                '#<(img|input)(>| .*?>)<\/\1>#s', // reset previous fix
                '#(&nbsp;)&nbsp;(?![<\s])#', // clean up ...
                '#(?<=\>)(&nbsp;)(?=\<)#', // --ibid
                // Remove HTML comment(s) except IE comment(s)
                '#\s*<!--(?!\[if\s).*?-->\s*|(?<!\>)\n+(?=\<[^!])#s'
            ],
            [
                '<$1$2</$1>',
                '$1$2$3',
                '$1$2$3',
                '$1$2$3$4$5',
                '$1$2$3$4$5$6$7',
                '$1$2$3',
                '<$1$2',
                '$1 ',
                '$1',
                ""
            ],
            $input);
    }
}
//------------------------------------------   ----------------  -----------------------------------------//

if (!function_exists('ltm_enCode_str'))
{
    function ltm_enCode_str($var)
    {
        return trim(encrypt($var));
    }
}

if (!function_exists('ltm_deCode_str'))
{
    function ltm_deCode_str($var)
    {
        try
        {
            return trim(decrypt($var));
        } catch (Illuminate\Contracts\Encryption\DecryptException $e)
        {
            return false;
        }
    }
}

if (!function_exists('ltm_ConvertNumbersEntoFa'))
{
    function ltm_ConvertNumbersEntoFa($matches)
    {
        $farsi_array = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english_array = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($english_array, $farsi_array, $matches);
    }
}

if (!function_exists('ltm_ConvertNumbersFatoEn'))
{
    function ltm_ConvertNumbersFatoEn($matches)
    {
        $farsi_array = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english_array = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($farsi_array, $english_array, $matches);
    }
}

if (!function_exists('ltm_JDate'))
{
    function ltm_JDate($format = "Y/m/d-H:i", $numberType = "fa", $stamp = false, $convert = null, $jalali = false, $timezone = "Asia/Tehran")
    {
        if ($stamp == false)
        {
            $stamp = time();
        }
        $date = new Hamahang\LTM\Helpers\Classes\jDateTime();
        $res = $date->date($format, $stamp);
        if ($numberType != "fa")
        {
            $res = ltm_ConvertNumbersFatoEn($res);
        }

        return $res;
    }
}

if (!function_exists('ltm_Date_GtoJ'))
{
    function ltm_Date_GtoJ($GDate = null, $Format = "Y/m/d-H:i", $convert = true)
    {
//        return $GDate;
        if ($GDate == '-0001-11-30 00:00:00' || $GDate == null)
        {
            return '--/--/----';
        }
        $date = new Hamahang\LTM\Helpers\Classes\jDateTime($convert, true, 'Asia/Tehran');
        $time = is_numeric($GDate) ? strtotime(date('Y-m-d H:i:s', $GDate)) : strtotime($GDate);

        return $date->date($Format, $time);

    }
}

if (!function_exists('ltm_Date_JtoG'))
{
    function ltm_Date_JtoG($jDate, $delimiter = '/', $to_string = false, $to_string_delimiter = '-', $zerofill = false)
    {
        $jDate = ltm_ConvertNumbersFatoEn($jDate);
        $date = explode($delimiter, $jDate);
        $r = Hamahang\LTM\Helpers\Classes\jDateTime::toGregorian($date[0], $date[1], $date[2]);
        if ($zerofill)
        {
            $r[1] = str_pad($r[1], 2, '0', STR_PAD_LEFT);
            $r[2] = str_pad($r[2], 2, '0', STR_PAD_LEFT);
        }
        if ($to_string)
        {
            $r = $r[0] . $to_string_delimiter . $r[1] . $to_string_delimiter . $r[2];
        }

        return ($r);
    }
}

if (!function_exists('ltm_human_date'))
{
    function ltm_human_date($timestamp, $past = true)
    {
        $t = abs(time() - $timestamp) / 60;
        switch (true)
        {
            case $t > 548 * 24 * 60;
                $r = ltm_JDate('Y-m-d', 'fa', $timestamp);
                break;
            case $t > 12 * 30 * 24 * 60;
                $r = '1 ' . trans('date.year'); //'1 سال';
                break;
            case $t > 9 * 30 * 24 * 60;
                $r = '9 ' . trans('date.month'); //'9 ماه';
                break;
            case $t > 6 * 30 * 24 * 60;
                $r = '6 ' . trans('date.month'); //'6 ماه';
                break;
            case $t > 3 * 30 * 24 * 60;
                $r = '3 ' . trans('date.month'); //'3 ماه';
                break;
            case $t > 31 * 24 * 60;
                $r = '1 ' . trans('date.month'); //'1 ماه';
                break;
            case $t > 7 * 24 * 60;
                $r = '1 ' . trans('date.week'); //'1 هفته';
                break;
            case $t > 6 * 24 * 60;
                $r = '6 ' . trans('date.day'); //'1 روز';
                break;
            case $t > 5 * 24 * 60;
                $r = '5 ' . trans('date.day'); //'1 روز';
                break;
            case $t > 4 * 24 * 60;
                $r = '4 ' . trans('date.day'); //'1 روز';
                break;
            case $t > 3 * 24 * 60;
                $r = '3 ' . trans('date.day'); //'1 روز';
                break;
            case $t > 2 * 24 * 60;
                $r = '2 ' . trans('date.day'); //'1 روز';
                break;
            case $t > 24 * 60;
                $r = '1 ' . trans('date.day'); //'1 روز';
                break;
            case $t > 12 * 60;
                $r = '12 ' . trans('date.hour'); //'12 ساعت';
                break;
            case $t > 11 * 60;
                $r = '11 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 10 * 60;
                $r = '10 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 9 * 60;
                $r = '9 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 8 * 60;
                $r = '8 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 7 * 60;
                $r = '7 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 6 * 60;
                $r = '6 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 5 * 60;
                $r = '5 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 4 * 60;
                $r = '4 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 3 * 60;
                $r = '3 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 2 * 60;
                $r = '2 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 60;
                $r = '1 ' . trans('date.hour'); //'ساعت';
                break;
            case $t > 30;
                $r = trans('date.halfhour'); //'نیم ساعت';
                break;
            case $t > 15;
                $r = trans('date.aquarter'); //'یک ربع';
                break;
            case $t > 1;
                $r = trans('date.daghayeghi'); //'دقایقی';
                break;
            case $t > 0;
                $r = trans('date.lahazati'); //'لحظاتی';
                break;
        }
        if ($past)
        {
            $r = $r . ' ' . trans('date.past');
        }

        return ($r);
    }
}

if (!function_exists('ltm_check_captcha'))
{
    function ltm_check_captcha($section, $value)
    {
        $session_name = 'captcha_' . $section;
        if (session()->has($session_name))
        {
            if (session($session_name) == $value)
            {
                session()->forget($session_name);

                return true;
            }
        }

        return false;
    }
}

if (!function_exists('ltm_generate_email_random_key'))
{
    function ltm_generate_email_random_key()
    {
        $random_key = md5(rand(1000, 50000));

        return $random_key;
    }
}

if (!function_exists('ltm_generate_sms_random_key'))
{
    function ltm_generate_sms_random_key($digits)
    {
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;

        return mt_rand($min, $max);
    }
}

if (!function_exists('ltm_buildTree'))
{
    /**
     * @param array $flat_array
     *     sometimes a boolean, sometimes a string (or, could have just used "mixed")
     * @param $pidKey
     * @param int $parent
     * @param string $idKey
     * @param string $children_key
     * @return mixed
     */
    function ltm_buildTree($flat_array, $pidKey, $parent = 0, $idKey = 'id', $children_key = 'children', $check_selectable = false, $array_check_pass_item = [])
    {
        if (empty($flat_array))
        {
            return [];
        }
        $grouped = [];
        foreach ($flat_array as $sub)
        {
            if ($check_selectable)
            {
                if (!$sub->$check_selectable($array_check_pass_item))
                {
                    $sub->state = ["disabled" => true];
                }
            }
            $grouped[ $sub[ $pidKey ] ][] = $sub;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped, $idKey, $children_key)
        {
            foreach ($siblings as $k => $sibling)
            {
                $id = $sibling[ $idKey ];
                if (isset($grouped[ $id ]))
                {
                    $sibling[ $children_key ] = $fnBuilder($grouped[ $id ]);
                }
                $siblings[ $k ] = $sibling;
            }

            return $siblings;
        };
        $tree = $fnBuilder($grouped[ $parent ]);

        return $tree;
    }
}

if (!function_exists('ltm_buildMenuTree'))
{
    /**
     * @param $flat_array
     * @param $pidKey
     * @param $openNodes
     * @param $selectedNodes
     * @param $item
     * @param int $parent
     * @param string $idKey
     * @param string $children_key
     * @return mixed
     */
    function ltm_buildMenuTree($flat_array, $pidKey, $item = false, $openNodes = false, $selectedNodes = [], $parent = 0, $idKey = 'id', $children_key = 'children')
    {
        $grouped = [];
        foreach ($flat_array as $sub)
        {
            $sub['text'] = $sub['title'];
            if ($sub['href'] != '' && $sub['href_type'] == 0)
            {
                $sub['a_attr']['href'] = $sub['href'];
            }
            else
            {
                if ($sub['href'] != '' && $sub['href_type'] == 1 && Auth::check())
                {
                    $sub['href'] = str_replace('[username]', Auth::user()->Uname, $sub['href']);
                    if ($item)
                    {
                        $sub['href'] = str_replace('[subject_id]', $item, $sub['href']);
                        $sub['href'] = str_replace('[page_id]', $item, $sub['href']);
                    }
                    $sub['a_attr']['href'] = url($sub['href']);
                }
                else
                {
                    $route_var = json_decode($sub['route_variable']);
                    /* @FixedMe change username var to current login user */
                    if ($route_var != null)
                    {
                        $result_route_var = [];
                        foreach ($route_var as $rk => $rv)
                        {
                            //$rv =json_decode($rv);
                            if (isset($rv->username) || empty($rv->username))
                            {
                                $result_route_var[ $rk ] = Auth::user()->Uname;
                            }
                        }

                        $sub['a_attr']['href'] = route($sub['route_name'], $result_route_var);
                    }
                    else
                    {
                        $sub['a_attr']['href'] = $sub['href'];
                    }
                }
            }

            if ($openNodes)
            {
                $sub['state']['opened'] = true;
            }

            if (in_array($sub['a_attr']['href'], $selectedNodes))
            {
                $sub['state']['selected'] = true;
            }
            $grouped[ $sub[ $pidKey ] ][] = $sub;
        }
        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped, $idKey, $children_key)
        {
            $siblings = sort_arr($siblings);
            foreach ($siblings as $k => $sibling)
            {
                $id = $sibling[ $idKey ];
                if (isset($grouped[ $id ]))
                {
                    $sibling[ $children_key ] = $fnBuilder($grouped[ $id ]);
                }
                $siblings[ $k ] = $sibling;
            }

            return $siblings;
        };
        if (isset($grouped[ $parent ]))
        {
            $tree = $fnBuilder($grouped[ $parent ]);
        }
        else
        {
            $tree = [];
        }

        return $tree;
    }

}

if (!function_exists('ltm_afreplace'))
{
    function ltm_afreplace($word)
    {
        $word = str_replace('ی', 'ي', $word);
        $word = str_replace('ک', 'ك', $word);

        return ($word);
    }
}

if (!function_exists('ltm_enCode'))
{
    function ltm_enCode($var)
    {
        $hashids = new \Hashids\Hashids();
        $var = $hashids->encode($var);

        return $var;
    }
}

if (!function_exists('ltm_deCode'))
{
    function ltm_deCode($var)
    {
        $hashids = new \Hashids\Hashids();
        $var = $hashids->deCode($var);

        return $var;
    }
}

if (!function_exists('ltm_date_diff_seconds'))
{
    function ltm_date_diff_seconds($start = 'Y-m-d h:i:s', $end = 'Y-m-d h:i:s', $get_minutes = false)
    {
        $d = date_diff(new DateTime($start), new DateTime($end));
        $s = ($d->days * 24 * 60 * 60) + ($d->h * 60 * 60) + ($d->i * 60) + ($d->s);
        $r = abs($get_minutes ? $s / 60 : $s);

        return $r;
    }
}

if (!function_exists('ltm_minutes_to_time'))
{
    /**
     * [THIS FUNCTION NEED TO BE MODIFIED.]
     *
     * @param $minutes
     * @param bool $human_readable
     * @return int|string|array
     */
    function ltm_minutes_to_time($minutes, $human_readable = false)
    {
        $seconds = $minutes * 60;
        $d = (new DateTime('@0'))->diff(new DateTime("@$seconds"));
        $r['days'] = $d->days;
        $r['hours'] = $d->h;
        $r['minutes'] = $d->i;
        $r['strings']['days'] = $d->days ? $d->days . ' ' . 'روز' : null;
        $r['strings']['hours'] = $d->h ? $d->h . ' ' . 'ساعت' : null;
        $r['strings']['minutes'] = $d->i ? $d->i . ' ' . 'دقیقه' : null;
        $r['text'] = 0;
        if ($r['strings']['minutes'])
        {
            $r['text'] = $r['strings']['minutes'];
        }
        if ($r['strings']['hours'])
        {
            $r['text'] = $r['strings']['hours'];
        }
        if ($r['strings']['days'])
        {
            $r['text'] = $r['strings']['days'];
        }
        if ($r['strings']['hours'] && $r['strings']['minutes'])
        {
            $r['text'] = $r['strings']['hours'] . ' و ' . $r['strings']['minutes'];
        }
        if ($r['strings']['days'] && $r['strings']['minutes'])
        {
            $r['text'] = $r['strings']['days'] . ' و ' . $r['strings']['minutes'];
        }
        if ($r['strings']['days'] && $r['strings']['hours'])
        {
            $r['text'] = $r['strings']['days'] . ' و ' . $r['strings']['hours'];
        }
        if ($r['strings']['days'] && $r['strings']['hours'] && $r['strings']['minutes'])
        {
            $r['text'] = implode(' و ', $r['strings']);
        }
        $r['strings']['interval'] = "P{$d->days}DT{$d->h}H{$d->i}M";
        return $human_readable ? $r['text'] : $r;
    }
}

if (!function_exists('ltm_encode_ids'))
{
    /**
     * @param array $ids
     * @param int $min_hash_length
     * @return string
     */
    function ltm_encode_ids(array $ids, $min_hash_length = 0)
    {
        return (new Hashids\Hashids(env('HASHIDS_SALT', config('const.hashids_salt')), $min_hash_length))->encode($ids);
    }
}

if (!function_exists('ltm_decode_ids'))
{
    /**
     * @param string $hash
     * @param integer|null $index
     * @return array|boolean|string
     */
    function ltm_decode_ids($hash, $index = null)
    {
        $r = (new Hashids\Hashids(env('HASHIDS_SALT', config('const.hashids_salt'))))->deCode($hash);
        return null !== $index ? (isset($r[$index]) ? $r[$index] : null) : $r;
    }
}

if (!function_exists('ltm_array_to_string_array'))
{
    function ltm_array_to_string_array($array)
    {
        $indexedOnly = [];
        foreach ($array as $row)
        {
            $indexedOnly[] = array_values($row);
        }

        return response()->json($indexedOnly);
    }
}

if (!function_exists('ltm_is_json'))
{
    /**
     * @param $string
     * @return bool
     */
    function ltm_is_json($string)
    {
        json_decode($string);
        return JSON_ERROR_NONE == json_last_error();
    }
}

if (!function_exists('ltm_task_log_store'))
{
    /**
     * @param $task_id
     * @param $type
     * @param null $task_assignment_id
     * @param array $description_values
     * @param array $title_values
     * @param int $created_by
     * @return mixed
     */
    function ltm_task_log_store($task_id, $type, $task_assignment_id = null, array $description_values = [], array $title_values = [], $created_by = 0)
    {
        $task_logs = new Hamahang\LTM\Models\Tasks\TaskLog;
        $task_logs->task_id = $task_id;
        $task_logs->type = $type;
        $task_logs->task_assignment_id = $task_assignment_id;
        $task_logs->description_values = is_array($description_values) ? json_encode($description_values, JSON_FORCE_OBJECT) : null;
        $task_logs->title_values = is_array($title_values) ? json_encode($title_values, JSON_FORCE_OBJECT) : null;
        $task_logs->created_by = $created_by;
        $task_logs->save();
        return $task_logs->id;
    }
}

if (!function_exists('ltm_task_log_fetch'))
{
    /**
     * @param $type
     * @param $values
     * @param string $of
     * @param bool $return
     * @param null $task_id
     * @return bool|\Illuminate\Config\Repository|mixed
     */
    function ltm_task_log_fetch($type, $values, $of = 'description', $return = false, $task_id = null)
    {
        $data = config("task_logs_data.$type");
        if (null === $data)
        {
            return false;
        } else
        {
            $data_of = config("task_logs_data.$type.$of");
            if (null === $data_of)
            {
                return false;
            } else
            {
                $text = config("task_logs_data.$type.$of.text");
                $functions = config("task_logs_data.$type.$of.values");
                if (empty($functions))
                {
                    return $text;
                } else
                {
                    $values = json_decode(ltm_is_json($values) ? $values : '{}', true);
                    foreach ($values as $k => $v)
                    {
                        if (array_key_exists($k, $functions))
                        {
                            $task_log = 'Hamahang\LTM\Helpers\Classes\TaskLog';
                            $values[$k] = method_exists($task_log, $functions[$k]) ? forward_static_call_array([$task_log, $functions[$k]], [$v, $task_id]) : $v;
                        }
                    }
                }
            }
        }
        foreach ($values as $k => $v)
        {
            $text = str_replace("[$k]", $v, $text);
        }
        return $text;
    }
}

if (!function_exists('ltm_make_task_code'))
{
    /**
     * @param $subject_code
     * @param $task_id
     * @param string $delimiter
     * @param null $prefix
     * @param null $suffix
     * @return string
     */
    function ltm_make_task_code($subject_code, $task_id, $delimiter = '_', $prefix = null, $suffix = null)
    {
        $t = str_pad($task_id, '7', '0', STR_PAD_LEFT);
        return "$prefix$subject_code$delimiter$t$suffix";
    }
}

if (!function_exists('ltm_create_iframe'))
{
    function ltm_create_iframe($route,$modal_id)
    {
        $html = '<iframe style="width:100%;height: calc(111vh);    max-height: calc(111vh);    border: none;" id="modal_'.$modal_id.'" src="'.$route.'"></iframe>';
        return $html ;
    }
}

if (!function_exists('ltm_create_task_button'))
{
    function ltm_create_task_button()
    {
        return '<button class="btn btn-xs btn-success jsPanels" data-href="'.route("ltm.modals.common.tasks.task.add").'" data-title="افزودن وظیفه جدید" data-reload="reload" style="margin-top: 7px;">افزودن وظیفه جدید</button>' ;
    }
}
if (!function_exists('check_subject_task_permission'))
{
    function check_subject_task_permission($subject_id)
    {
        $check = false ;
        if (function_exists( config('laravel_task_manager.task_assigments_users_id_function_name')))
        {
            $subjects = config('laravel_task_manager.task_assigments_subject_function_name')() ;
        }
        else
        {
            $subjects = Hamahang\LTM\Models\Subject::select('id', 'title as text')->where('is_active', '1') ;

        }
        foreach ($subjects->get() as $subject)
        {
            if ($subject->id == $subject_id)
            {
                $check = true ;
            }
        }
        return $check ;
    }
}
if (!function_exists('check_user_task_permission'))
{
    function check_user_task_permission($usres_id)
    {
        $check = false ;
        if (function_exists( config('laravel_task_manager.task_assigments_users_id_function_name')))
        {
            $users = config('laravel_task_manager.task_assigments_users_id_function_name')() ;

        }
        else
        {
            $users = config('laravel_task_manager.user_model')::select('id', DB::raw('CONCAT(first_name, " ", last_name, " (", username, ")") AS text'));

        }
        foreach ($users->get() as $user)
        {
            if (in_array($user->id,$usres_id))
            {
                $check = true ;
            }
        }
        return $check ;
    }
}

if (!function_exists('ltm_task_assigments_default_users_id'))
{
    function ltm_task_assigments_default_users_id()
    {
        return [4] ;
    }
}

if (!function_exists('ltm_task_assigments_users_id'))
{
    function ltm_task_assigments_users_id()
    {
        $data = config('laravel_task_manager.user_model')::select('id', DB::raw('CONCAT(first_name, " ", last_name, " (", username, ")") AS text'));
        return $data ;
    }
}

if (!function_exists('ltm_task_assigments_subjects'))
{
    function ltm_task_assigments_subjects()
    {
        $data = Hamahang\LTM\Models\Subject::select('id', 'title as text')->where('is_active', '1') ;
        return $data ;
    }
}

if (!function_exists('ltm_html_file_no_creator'))
{
    function ltm_html_file_no_creator($file_no)
    {
        return $file_no ;
    }
}

if (!function_exists('ltm_get_step'))
{
    function ltm_get_step($step_id)
    {
        return -1 ;
    }
}
if (!function_exists('ltm_get_file_no'))
{
    function ltm_get_file_no($file_no_id)
    {
        return false ;
    }
}

if (!function_exists('ltm_get_user_id'))
{
    function ltm_get_user_id()
    {
        return auth()->id() ;
    }
}
if (!function_exists('ltm_show_client_route'))
{
    function ltm_show_client_route()
    {
        return true ;
    }
}

if (!function_exists('ltm_task_transcript_user_id'))
{
    function ltm_task_transcript_user_id()
    {
       return [1,389] ;
    }
}
