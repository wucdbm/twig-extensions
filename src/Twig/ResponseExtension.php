<?php

namespace Wucdbm\TwigExtensions\Twig;

use Symfony\Component\HttpFoundation\Response;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ResponseExtension extends AbstractExtension {

    public function getFilters() {
        return [
            new TwigFilter('responseStatus', [$this, 'responseStatus'])
        ];
    }

    public function responseStatus($code) {
        if (isset(Response::$statusTexts[$code])) {
            return Response::$statusTexts[$code];
        }

        return sprintf('Status Code %s', $code);
    }

}