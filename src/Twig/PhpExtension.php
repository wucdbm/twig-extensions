<?php

namespace Wucdbm\TwigExtensions\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhpExtension extends AbstractExtension {

    public function getFilters() {
        return [
            new TwigFilter('get_class', [$this, 'get_class']),
            new TwigFilter('fqcn', [$this, 'fqcn']),
            new TwigFilter('unserialize', 'unserialize'),
            new TwigFilter('file_get_contents', 'file_get_contents'),
            new TwigFilter('intval', 'intval'),
            new TwigFilter('floatval', 'floatval'),
            new TwigFilter('ip2long', 'ip2long'),
            new TwigFilter('long2ip', 'long2ip')
        ];
    }

    public function get_class($object, $default = '') {
        $fqcn = $this->fqcn($object);

        if ($fqcn) {
            $parts = explode('\\', $fqcn);

            return array_pop($parts);
        }

        return $default;
    }

    public function fqcn($object, $default = '') {
        if (is_object($object)) {
            return get_class($object);
        }

        return $default;
    }

}