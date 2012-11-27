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
        $fileContents = $asset->getContent();
        // remove comments
        $fileContents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $fileContents);
        // remove line breaks and multispaces
        $fileContents = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $fileContents);
        $asset->setContent($fileContents);
    }
}
