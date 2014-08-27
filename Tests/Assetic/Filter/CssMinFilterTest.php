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
     * @dataProvider provideCssWithComments
     */
    public function testRemovesComments($inputCss, $expectedCss)
    {
        $asset = new StringAsset($inputCss);
        $asset->load();

        $filter = new CssMinFilter();
        $filter->filterDump($asset);

        $this->assertEquals($expectedCss, $asset->getContent(), '->filterDump() removes comments');
    }

    public function provideCssWithComments()
    {
        return array(
            // single line comments in various css definition
            array('body { width: 960px; /***** Body Width *****/ }', 'body{width:960px}'),
            array(<<<EOF
/*** This wrapper ***/div.wrapper {
    color: white;
}
/*** This wrapper ***/
EOF
, 'div.wrapper{color:white}'),
            // multi line comments in various css definition
            array(<<<EOF
/*** This wrapper
Some more ***/
div.wrapper {
    color: white;
}
/*** This wrapper ***/
EOF
, ' div.wrapper{color:white}'),
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
, ' div.wrapper{color:white;text-align:center}')
        );
    }

    /**
     * @dataProvider provideCss
     */
    public function testRemovesWhitespaceAndLineBreaks($inputCss, $expectedCss)
    {
        $asset = new StringAsset($inputCss);
        $asset->load();

        $filter = new CssMinFilter();
        $filter->filterDump($asset);

        $this->assertEquals($expectedCss, $asset->getContent(), '->filterDump() removes whitespace and comments');
    }

    public function provideCss()
    {
        return array(
            // whitespace in css
            array('   div#wrapper    {   color:     white;   }   ', ' div#wrapper{color:white}'),
            array('div#wrapper    {color:     white;   }   ', 'div#wrapper{color:white}'),
            array(
                'ul.sub-nav li.line [type="text"]                         { padding:5px 2px 3px 2px; display:block; border:none; font:11px "Georgia", "Times New Roman", Helvetica, Arial, sans-serif; color:#4A4440; background:transparent  url(\'../../bundles/avondalelayout/images/icon-search.png\') no-repeat right 3px; border:none; border-bottom:1px solid #5f594c; letter-spacing:0.7px; -webkit-appearance:none; }',
                'ul.sub-nav li.line [type="text"]{padding:5px 2px 3px 2px;display:block;border:none;font:11px "Georgia","Times New Roman",Helvetica,Arial,sans-serif;color:#4A4440;background:transparent url(\'../../bundles/avondalelayout/images/icon-search.png\') no-repeat right 3px;border:none;border-bottom:1px solid #5f594c;letter-spacing:0.7px;-webkit-appearance:none}'
            ),
            // whitespace in css
            array('   div#wrapper    {
                color:     white;
            }   ', ' div#wrapper{color:white}'
            ),
            array('div#wrapper    {color:     white;   }   ', 'div#wrapper{color:white}')
        );
    }

    public function testFullMinification()
    {
        $asset = new StringAsset(file_get_contents(__DIR__.'/full.css'));
        $asset->load();

        $minifiedAsset = new StringAsset(file_get_contents(__DIR__.'/minified.css'));
        $minifiedAsset->load();

        $filter = new CssMinFilter();
        $filter->filterDump($asset);

        $this->assertEquals($minifiedAsset->getContent(), $asset->getContent(), '->filterDump() minifies full css file');
    }
}
