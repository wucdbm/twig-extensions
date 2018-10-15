<?php

namespace Wucdbm\TwigExtensions\Twig;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SumExtension extends AbstractExtension {

    /** @var ExpressionLanguage */
    protected $language;

    /** @var PropertyAccessor */
    protected $accessor;

    public function __construct(?ExpressionLanguage $language) {
        if (null === $language) {
            $language = new ExpressionLanguage();
        }
        $this->language = $language;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function getFilters() {
        return [
            new TwigFilter('implode', [$this, 'implode']),
            new TwigFilter('sum', [$this, 'sum']),
            new TwigFilter('count', [$this, 'count']),
            new TwigFilter('array_unique', [$this, 'array_unique'])
        ];
    }

    public function implode($arrayOrObject, $glue, $propertyPath = null, $expression = null) {
        $pieces = [];
        foreach ($arrayOrObject as $value) {
            $shouldImplode = true;
            if (null !== $expression) {
                $shouldImplode = $this->language->evaluate($expression, array(
                    'value' => $value
                ));
            }
            if ($shouldImplode) {
                if ($propertyPath) {
                    $value = $this->accessor->getValue($value, $propertyPath);
                }
                $pieces[] = $value;
            }
        }

        return implode($glue, $pieces);
    }

    public function sum($arrayOrObject, $propertyPath = null, $expression = null) {
        $sum = 0;
        foreach ($arrayOrObject as $value) {
            $shouldSum = true;
            if (null !== $expression) {
                $shouldSum = $this->language->evaluate($expression, array(
                    'value' => $value
                ));
            }
            if ($shouldSum) {
                if ($propertyPath) {
                    $value = $this->accessor->getValue($value, $propertyPath);
                }
                $sum += $value;
            }
        }

        return $sum;
    }

    public function array_unique($arrayOrObject, $propertyPath = null, $expression = null, $sortType = SORT_REGULAR) {
        $values = [];
        foreach ($arrayOrObject as $value) {
            $shouldAdd = true;
            if (null !== $expression) {
                $shouldAdd = $this->language->evaluate($expression, [
                    'value' => $value
                ]);
            }
            if ($shouldAdd) {
                if ($propertyPath) {
                    $value = $this->accessor->getValue($value, $propertyPath);
                }
                $values[] = $value;
            }
        }

        return array_unique($values, $sortType);
    }

    public function count($arrayOrObject, $expression = null) {
        $count = 0;
        foreach ($arrayOrObject as $value) {
            $shouldSum = true;
            if (null !== $expression) {
                $shouldSum = $this->language->evaluate($expression, array(
                    'value' => $value
                ));
            }
            if ($shouldSum) {
                $count++;
            }
        }

        return $count;
    }

}