<?php

namespace Beelab\SimplePageBundle\Util;

class BreadCrumbs
{
    /**
     * Create breadcrumbs from a path
     * Example: if $path is "foo/bar/baz", $return is [
     *     'foo'         => 'foo',
     *     'foo/bar'     => 'bar',
     *     'foo/bar/baz' => 'baz',
     * ].
     *
     * @param string $path
     *
     * @return array
     */
    public static function create($path)
    {
        $return = [];
        $breadCrumbs = explode('/', $path);
        $length = count($breadCrumbs);
        for ($i = 1; $i <= $length; ++$i) {
            $current = '';
            for ($j = 1; $j <= $i; ++$j) {
                $current .= $breadCrumbs[$j - 1].($j == $i ? '' : '/');
            }
            $return[$current] = $breadCrumbs[$i - 1];
        }

        return $return;
    }
}
