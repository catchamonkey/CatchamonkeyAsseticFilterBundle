<?php

/*
 * This file is part of the CatchamonkeyAsseticFilterBundle package.
 *
 * (c) catchamonkey <http://github.com/catchamonkey>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Catchamonkey\Bundle\AsseticFilterBundle\Tests\Assetic\Filter;

use Assetic\Asset\StringAsset;
use Catchamonkey\Bundle\AsseticFilterBundle\Assetic\Filter\CssMinFilter;

/**
 * Provides Tests of the CSS Minification Filter
 *
 * @author Chris Sedlmayr (catchamonkey) <chris@sedlmayr.co.uk>
 */
class CssMinFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideCssWithSingleLineComments
     */
    public function testRemovesSingleLineComments($inputCss, $expectedCss)
    {
        $asset = new StringAsset($inputCss);
        $asset->load();

        $filter = new CssMinFilter();
        $filter->filterLoad($asset);
        $filter->filterDump($asset);

        $this->assertEquals($expectedCss, $asset->getContent(), '->filterDump() removes single line comments');
    }

    public function provideCssWithSingleLineComments()
    {
        return array(
            // single line comments in various css definition
            array('body { width: 960px; /***** Body Width *****/ }', 'body { width: 960px;}'),
            array(<<<EOF
/*** This wrapper ***/div.wrapper {
    color: white;
}
/*** This wrapper ***/
EOF
, 'div.wrapper {color: white;}')
        );
    }

    /**
     * @dataProvider provideCssWithMultiLineComments
     */
    public function testRemovesMultiLineComments($inputCss, $expectedCss)
    {
        $asset = new StringAsset($inputCss);
        $asset->load();

        $filter = new CssMinFilter();
        $filter->filterLoad($asset);
        $filter->filterDump($asset);

        $this->assertEquals($expectedCss, $asset->getContent(), '->filterDump() removes multi line comments');
    }

    public function provideCssWithMultiLineComments()
    {
        return array(
            // multi line comments in various css definition
            array(<<<EOF
/*** This wrapper
Some more ***/
div.wrapper {
    color: white;
}
/*** This wrapper ***/
EOF
, 'div.wrapper {color: white;}'),
            array(<<<EOF
/***
This wrapper
Some more
***/
div.wrapper {
    color: white;
    text-align: center;
}
/*** This wrapper
has more comments 
too ***/
EOF
, 'div.wrapper {color: white;text-align: center;}')
        );
    }

    /**
     * @dataProvider provideCssWithWhitespace
     */
    public function testRemovesWhitespace($inputCss, $expectedCss)
    {
        $asset = new StringAsset($inputCss);
        $asset->load();

        $filter = new CssMinFilter();
        $filter->filterLoad($asset);
        $filter->filterDump($asset);

        $this->assertEquals($expectedCss, $asset->getContent(), '->filterDump() removes multi line comments');
    }

    public function provideCssWithWhitespace()
    {
        return array(
            // whitespace in css
            array('   div#wrapper    {   color:     white;   }   ', ' div#wrapper{ color: white; } '),
            array('div#wrapper    {color:     white;   }   ', 'div#wrapper{color: white; } ')
        );
    }

    /**
     * @dataProvider provideCssWithLineBreaks
     */
    public function testRemovesLineBreaks($inputCss, $expectedCss)
    {
        $asset = new StringAsset($inputCss);
        $asset->load();

        $filter = new CssMinFilter();
        $filter->filterLoad($asset);
        $filter->filterDump($asset);

        $this->assertEquals($expectedCss, $asset->getContent(), '->filterDump() removes line breaks');
    }

    public function provideCssWithLineBreaks()
    {
        return array(
            // whitespace in css
            array('   div#wrapper    {
                color:     white;
            }   ', ' div#wrapper{color: white;} '),
            array('div#wrapper    {color:     white;   }   ', 'div#wrapper{color: white; } ')
        );
    }

    public function testFullMinification()
    {
        $asset = new StringAsset(file_get_contents(__DIR__.'/full.css'));
        $asset->load();

        $minifiedAsset = new StringAsset(file_get_contents(__DIR__.'/minified.css'));
        $minifiedAsset->load();

        $filter = new CssMinFilter();
        $filter->filterLoad($asset);
        $filter->filterDump($asset);

        $this->assertEquals($minifiedAsset->getContent(), $asset->getContent(), '->filterDump() minifies full css file');
    }
}