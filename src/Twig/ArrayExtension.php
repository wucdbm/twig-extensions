<?php

namespace Wucdbm\TwigExtensions\Twig;

use Twig\TwigFilter;

class ArrayExtension extends \Twig_Extension {

    public function getFilters() {
        return [
            new TwigFilter('array_chunk', [$this, 'array_chunk']),
            new TwigFilter('urlEncodedToArray', [$this, 'urlEncodedToArray'])
        ];
    }

    /**
     * @param $encoded
     * @return \Generator|null
     */
    public function urlEncodedToArray($encoded) {
        if (!$encoded) {
            return;
        }

        $array = explode('&', $encoded);

        foreach ($array as $v) {
            if (false === strpos($v, '=')) {
                continue;
            }

            list($key, $value) = explode('=', $v);
            yield [$key => $value];
        }
    }

    public function array_chunk($input, $size, $preserve_keys = null) {
        if ($input instanceof \Traversable) {
            $arr = array();
            foreach ($input as $val) {
                $arr[] = $val;
            }

            return array_chunk($arr, $size, $preserve_keys);
        }

        return array_chunk($input, $size, $preserve_keys);
    }

}