<?php

/*
 * This file is part of the CatchamonkeyAsseticFilterBundle package.
 *
 * (c) catchamonkey <http://github.com/catchamonkey>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Catchamonkey\Bundle\AsseticFilterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Handles configuration information for the bundle
 *
 * @author Chris Sedlmayr (catchamonkey) <chris@sedlmayr.co.uk>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('catchamonkey_assetic_filter');

        return $treeBuilder;
    }
}
