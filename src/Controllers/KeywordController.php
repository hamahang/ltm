<?php

namespace Hamahang\LTM\Controllers;

use Hamahang\LTM\Models\Keyword;

class KeywordController extends Controller
{
    public static function make(array $keywords)
    {
        foreach ($keywords as $k => $v)
        {
            $check = (int) $v;
            if (!$check)
            {
                $keyword = new Keyword;
                $keyword->title = $v;
                $keyword->created_by = auth()->id() ? : 0;
                $keyword->save();
                $keywords[$k] = "$keyword->id";
            }
        }
        return $keywords;
    }
}
