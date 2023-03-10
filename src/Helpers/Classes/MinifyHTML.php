<?php

namespace Hamahang\LTM\Helpers\Classes ;

class MinifyHTML
{

    private $protocol;
    private $host;
    private $url;
    private $X = "\x1A";
    private $MINIFY_STRING = '"(?:[^"\\\]|\\\.)*"|\'(?:[^\'\\\]|\\\.)*\'';
    private $MINIFY_COMMENT_CSS = '/\*[\s\S]*?\*/';
    private $MINIFY_COMMENT_HTML = '<!\-{2}[\s\S]*?\-{2}>';
    private $MINIFY_COMMENT_JS = '//[^\n]*';
    private $MINIFY_PATTERN_JS = '/[^\n]+?/[gimuy]*';
    private $MINIFY_HTML = '<[!/]?[a-zA-Z\d:.-]+[\s\S]*?>';
    private $MINIFY_HTML_ENT = '&(?:[a-zA-Z\d]+|\#\d+|\#x[a-fA-F\d]+);';
    private $MINIFY_HTML_KEEP = '<pre(?:\s[^<>]*?)?>[\s\S]*?</pre>|<code(?:\s[^<>]*?)?>[\s\S]*?</code>|<script(?:\s[^<>]*?)?>[\s\S]*?</script>|<style(?:\s[^<>]*?)?>[\s\S]*?</style>|<textarea(?:\s[^<>]*?)?>[\s\S]*?</textarea>';

    function __construct()
    {
        $this->protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] === 443 ? 'https' : 'http') . '://';
        $this->host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : "");
        $this->url = $this->protocol . $this->host;
    }


    // normalize line–break(s)
    public function n($s)
    {
        return str_replace(["\r\n", "\r"], "\n", $s);
    }

    // trim once
    private function t($a, $b)
    {
        if ($a && strpos($a, $b) === 0 && substr($a, -strlen($b)) === $b)
        {
            return substr(substr($a, strlen($b)), 0, -strlen($b));
        }
        return $a;
    }

    private function fn_minify($pattern, $input)
    {
        return preg_split('#(' . implode('|', $pattern) . ')#', $input, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    }

    private function fn_ltm_minify_css($input, $comment = 2, $quote = 2)
    {
        if (!is_string($input) || !$input = $this->n(trim($input)))
        {
            return $input;
        }
        $output = $prev = "";
        foreach ($this->fn_minify([$this->MINIFY_COMMENT_CSS, $this->MINIFY_STRING], $input) as $part)
        {
            if (trim($part) === "")
            {
                continue;
            }
            if ($comment !== 1 && strpos($part, '/*') === 0 && substr($part, -2) === '*/')
            {
                if (
                    $comment === 2 && (
                        // Detect special comment(s) from the third character. It should be a `!` or `*` → `/*! keep */` or `/** keep */`
                        strpos('*!', $part[2]) !== false ||
                        // Detect license comment(s) from the content. It should contains character(s) like `@license`
                        stripos($part, '@licence') !== false || // noun
                        stripos($part, '@license') !== false || // verb
                        stripos($part, '@preserve') !== false
                    )
                )
                {
                    $output .= $part;
                }
                continue;
            }
            if ($part[0] === '"' && substr($part, -1) === '"' || $part[0] === "'" && substr($part, -1) === "'")
            {
                // Remove quote(s) where possible …
                $q = $part[0];
                if (
                    $quote !== 1 && (
                        // <https://www.w3.org/TR/CSS2/syndata.html#uri>
                        substr($prev, -4) === 'url(' && preg_match('#\burl\($#', $prev) ||
                        // <https://www.w3.org/TR/CSS2/syndata.html#characters>
                        substr($prev, -1) === '=' && preg_match('#^' . $q . '[a-zA-Z_][\w-]*?' . $q . '$#', $part)
                    )
                )
                {
                    $part = $this->t($part, $q); // trim quote(s)
                }
                $output .= $part;
            }
            else
            {
                $output .= $this->fn_ltm_minify_css_union($part);
            }
            $prev = $part;
        }
        return trim($output);
    }

    private function fn_ltm_minify_css_union($input)
    {
        if (stripos($input, 'calc(') !== false)
        {
            // Keep important white–space(s) in `calc()`
            $input = preg_replace_callback('#\b(calc\()\s*(.*?)\s*\)#i', function ($m)
            {
                return $m[1] . preg_replace('#\s+#', $this->X, $m[2]) . ')';
            }, $input);
        }
        $input = preg_replace([
            // Fix case for `#foo<space>[bar="baz"]`, `#foo<space>*` and `#foo<space>:first-child` [^1]
            '#(?<=[\w])\s+(\*|\[|:[\w-]+)#',
            // Fix case for `[bar="baz"]<space>.foo`, `*<space>.foo`, `:nth-child(2)<space>.foo` and `@media<space>(foo: bar)<space>and<space>(baz: qux)` [^2]
            '#([*\]\)])\s+(?=[\w\#.])#', '#\b\s+\(#', '#\)\s+\b#',
            // Minify HEX color code … [^3]
            '#\#([a-f\d])\1([a-f\d])\2([a-f\d])\3\b#i',
            // Remove white–space(s) around punctuation(s) [^4]
            '#\s*([~!@*\(\)+=\{\}\[\]:;,>\/])\s*#',
            // Replace zero unit(s) with `0` [^5]
            '#\b(?<!\d\.)(?:0+\.)?0+(?:[a-z]+\b)#i',
            // Replace `0.6` with `.6` [^6]
            '#\b0+\.(\d+)#',
            // Replace `:0 0`, `:0 0 0` and `:0 0 0 0` with `:0` [^7]
            '#:(0\s+){0,3}0(?=[!,;\)\}]|$)#',
            // Replace `background(?:-position)?:(0|none)` with `background$1:0 0` [^8]
            '#\b(background(?:-position)?):(?:0|none)([;,\}])#i',
            // Replace `(border(?:-radius)?|outline):none` with `$1:0` [^9]
            '#\b(border(?:-radius)?|outline):none\b#i',
            // Remove empty selector(s) [^10]
            '#(^|[\{\}])(?:[^\{\}]+)\{\}#',
            // Remove the last semi–colon and replace multiple semi–colon(s) with a semi–colon [^11]
            '#;+([;\}])#',
            // Replace multiple white–space(s) with a space [^12]
            '#\s+#'
        ], [
            // [^1]
            $this->X . '$1',
            // [^2]
            '$1' . $this->X, $this->X . '(', ')' . $this->X,
            // [^3]
            '#$1$2$3',
            // [^4]
            '$1',
            // [^5]
            '0',
            // [^6]
            '.$1',
            // [^7]
            ':0',
            // [^8]
            '$1:0 0$2',
            // [^9]
            '$1:0',
            // [^10]
            '$1',
            // [^11]
            '$1',
            // [^12]
            ' '
        ], $input);
        return trim(str_replace($this->X, ' ', $input));
    }

    private function fn_ltm_minify_html($input, $comment = 2, $quote = 1)
    {
        if (!is_string($input) || !$input = $this->n(trim($input)))
        {
            return $input;
        }
        $output = $prev = "";
        foreach ($this->fn_minify([$this->MINIFY_COMMENT_HTML, $this->MINIFY_HTML_KEEP, $this->MINIFY_HTML, $this->MINIFY_HTML_ENT], $input) as $part)
        {
            if ($part === "\n")
            {
                continue;
            }
            if ($part !== ' ' && trim($part) === "" || $comment !== 1 && strpos($part, '<!--') === 0)
            {
                // Detect IE conditional comment(s) by its closing tag …
                if ($comment === 2 && substr($part, -12) === '<![endif]-->')
                {
                    $output .= $part;
                }
                continue;
            }
            if ($part[0] === '<' && substr($part, -1) === '>')
            {
                $output .= $this->fn_ltm_minify_html_union($part, $quote);
            }
            else
            {
                if ($part[0] === '&' && substr($part, -1) === ';' && $part !== '&lt;' && $part !== '&gt;' && $part !== '&amp;')
                {
                    $output .= html_entity_decode($part); // Evaluate HTML entit(y|ies)
                }
                else
                {
                    $output .= preg_replace('#\s+#', ' ', $part);
                }
            }
            $prev = $part;
        }
        $output = str_replace(' </', '</', $output);
        // Force space with `&#x0020;` and line–break with `&#x000A;`
        return str_ireplace(['&#x0020;', '&#x20;', '&#x000A;', '&#xA;'], [' ', ' ', "\n", "\n"], trim($output));
    }

    private function fn_ltm_minify_html_union($input, $quote)
    {
        if (
            strpos($input, ' ') === false &&
            strpos($input, "\n") === false &&
            strpos($input, "\t") === false
        )
        {
            return $input;
        }
        return preg_replace_callback('#<\s*([^\/\s]+)\s*(?:>|(\s[^<>]+?)\s*>)#', function ($m) use ($quote)
        {
            if (isset($m[2]))
            {
                // Minify inline CSS(s)
                if (stripos($m[2], ' style=') !== false)
                {
                    $m[2] = preg_replace_callback('#( style=)([\'"]?)(.*?)\2#i', function ($m)
                    {
                        return $m[1] . $m[2] . $this->fn_ltm_minify_css($m[3]) . $m[2];
                    }, $m[2]);
                }
                // Minify URL(s)
                if (strpos($m[2], '://') !== false)
                {
                    $m[2] = str_replace([
                        $this->url . '/',
                        $this->url . '?',
                        $this->url . '&',
                        $this->url . '#',
                        $this->url . '"',
                        $this->url . "'"
                    ], [
                        '/',
                        '?',
                        '&',
                        '#',
                        '/"',
                        "/'"
                    ], $m[2]);
                }
                $a = 'a(sync|uto(focus|play))|c(hecked|ontrols)|d(efer|isabled)|hidden|ismap|loop|multiple|open|re(adonly|quired)|s((cop|elect)ed|pellcheck)';
                $a = '<' . $m[1] . preg_replace([
                        // From `a="a"`, `a='a'`, `a="true"`, `a='true'`, `a=""` and `a=''` to `a` [^1]
                        '#\s(' . $a . ')(?:=([\'"]?)(?:true|\1)?\2)#i',
                        // Remove extra white–space(s) between HTML attribute(s) [^2]
                        '#\s*([^\s=]+?)(=(?:\S+|([\'"]?).*?\3)|$)#',
                        // From `<img />` to `<img/>` [^3]
                        '#\s+\/$#'
                    ], [
                        // [^1]
                        ' $1',
                        // [^2]
                        ' $1$2',
                        // [^3]
                        '/'
                    ], str_replace("\n", ' ', $m[2])) . '>';
                return $quote !== 1 ? $this->fn_ltm_minify_html_union_attr($a) : $a;
            }
            return '<' . $m[1] . '>';
        }, $input);
    }

    private function fn_ltm_minify_html_union_attr($input)
    {
        if (strpos($input, '=') === false)
        {
            return $input;
        }
        return preg_replace_callback('#=(' . $this->MINIFY_STRING . ')#', function ($m)
        {
            $q = $m[1][0];
            if (strpos($m[1], ' ') === false && preg_match('#^' . $q . '[a-zA-Z_][\w-]*?' . $q . '$#', $m[1]))
            {
                return '=' . $this->t($m[1], $q);
            }
            return $m[0];
        }, $input);
    }

    private function fn_ltm_minify_js($input, $comment = 2, $quote = 2)
    {
        if (!is_string($input) || !$input = $this->n(trim($input)))
        {
            return $input;
        }
        $output = $prev = "";
        foreach ($this->fn_minify([$this->MINIFY_COMMENT_CSS, $this->MINIFY_STRING, $this->MINIFY_COMMENT_JS, $this->MINIFY_PATTERN_JS], $input) as $part)
        {
            if (trim($part) === "")
            {
                continue;
            }
            if ($comment !== 1 && (
                    strpos($part, '//') === 0 || // Remove inline comment(s)
                    strpos($part, '/*') === 0 && substr($part, -2) === '*/'
                )
            )
            {
                if (
                    $comment === 2 && (
                        // Detect special comment(s) from the third character. It should be a `!` or `*` → `/*! keep */` or `/** keep */`
                        strpos('*!', $part[2]) !== false ||
                        // Detect license comment(s) from the content. It should contains character(s) like `@license`
                        stripos($part, '@licence') !== false || // noun
                        stripos($part, '@license') !== false || // verb
                        stripos($part, '@preserve') !== false
                    )
                )
                {
                    $output .= $part;
                }
                continue;
            }
            if ($part[0] === '/' && (substr($part, -1) === '/' || preg_match('#\/[gimuy]*$#', $part)))
            {
                $output .= $part;
            }
            else
            {
                if ($part[0] === '"' && substr($part, -1) === '"' || $part[0] === "'" && substr($part, -1) === "'")
                {
                    // TODO: Remove quote(s) where possible …
                    $output .= $part;
                }
                else
                {
                    $output .= $this->fn_ltm_minify_js_union($part);
                }
            }
            $prev = $part;
        }
        return $output;
    }

    private function fn_ltm_minify_js_union($input)
    {
        return preg_replace([
            // Remove white–space(s) around punctuation(s) [^1]
            '#\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#',
            // Remove the last semi–colon and comma [^2]
            '#[;,]([\]\}])#',
            // Replace `true` with `!0` and `false` with `!1` [^3]
            '#\btrue\b#', '#\bfalse\b#', '#\b(return\s?)\s*\b#',
            // Replace `new Array(x)` with `[x]` … [^4]
            '#\b(?:new\s+)?Array\((.*?)\)#', '#\b(?:new\s+)?Object\((.*?)\)#'
        ], [
            // [^1]
            '$1',
            // [^2]
            '$1',
            // [^3]
            '!0', '!1', '$1',
            // [^4]
            '[$1]', '{$1}'
        ], $input);
    }


    /**
     * Backward Compatibility
     * ----------------------
     */
    public function ltm_minify_css(...$lot)
    {
        return $this->fn_ltm_minify_css(...$lot);
    }

    public function ltm_minify_html(...$lot)
    {
        return $this->fn_ltm_minify_html(...$lot);
    }

    public function ltm_minify_js(...$lot)
    {
        return $this->fn_ltm_minify_js(...$lot);
    }


}
