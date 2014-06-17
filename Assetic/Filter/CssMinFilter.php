<?php

/*
 * This file is part of the CatchamonkeyAsseticFilterBundle package.
 *
 * (c) catchamonkey <http://github.com/catchamonkey>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Catchamonkey\Bundle\AsseticFilterBundle\Assetic\Filter;

use Assetic\Filter\FilterInterface;
use Assetic\Asset\AssetInterface;

/**
 * Implements a CSS Minification Filter
 *
 * @author Chris Sedlmayr (catchamonkey) <chris@sedlmayr.co.uk>
 */
class CssMinFilter implements FilterInterface
{
    protected $options;

    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    public function filterLoad(AssetInterface $asset)
    {
    }

    public function filterDump(AssetInterface $asset)
    {
        $string = $asset->getContent();

        // comments
        $string = preg_replace('!/\*.*?\*/!s','', $string);
        $string = preg_replace('/\n\s*\n/',"\n", $string);

        // space
        $string = preg_replace('/[\n\r \t]/',' ', $string);
        $string = preg_replace('/ +/',' ', $string);
        $string = preg_replace('/ ?([,:;{}]) ?/','$1',$string);

        // trailing semi-colon
        $string = preg_replace('/;}/','}',$string);

        $asset->setContent($string);
    }
}
