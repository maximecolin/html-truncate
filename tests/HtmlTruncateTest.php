<?php

/*
 * This file is part of the HtmlTruncate package.
 *
 * (c) Maxime Colin <contact@maximecolin.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HtmlTruncate\Tests;

use HtmlTruncate\HtmlTruncate;

class HtmlTruncateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public static function provideHtml()
    {
        return [
            [
                '<p>Lorem ipsum dolor sit amet</p>',
                7,
                '',
                '<p>Lorem i</p>',
            ],
            [
                '<p>Lorem ipsum dolor sit amet</p>',
                7,
                '...',
                '<p>Lorem i...</p>',
            ],
            [
                '<article><h1>Lorem ipsum</h1><p>Lorem ipsum dolor sit amet</p></article>',
                15,
                '',
                '<article><h1>Lorem ipsum</h1><p>Lore</p></article>',
            ],
            [
                '<article><h1>Lorem ipsum</h1><p>Lorem ipsum dolor sit amet</p><p>Pellentesque habitant morbi tristique senectus</p></article>',
                15,
                '',
                '<article><h1>Lorem ipsum</h1><p>Lore</p></article>',
            ],
            [
                '<article><h1>Lorem ipsum</h1><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p><ul><li>Lorem ipsum doloris</li><li>Pellentesque habitant morbi tristique</li></ul></article>',
                119,
                '',
                '<article><h1>Lorem ipsum</h1><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p><ul><li>Lorem ipsum dol</li></ul></article>',
            ],
            [
                '<article><h1>Lorem ipsum</h1><img src="image.jpg" alt="image" /><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p><ul><li>Lorem ipsum doloris</li><li>Pellentesque habitant morbi tristique</li></ul></article>',
                119,
                '',
                '<article><h1>Lorem ipsum</h1><img src="image.jpg" alt="image" /><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p><ul><li>Lorem ipsum dol</li></ul></article>',
            ],
        ];
    }

    /**
     * @dataProvider provideHtml
     *
     * @param string $html
     * @param int    $length
     * @param string $append
     * @param string $expected
     */
    public function testTruncate($html, $length, $append, $expected)
    {
        $this->assertHtmlStringEqualsHtmlString($expected, (new HtmlTruncate())->truncate($html, $length, $append));
    }

    /**
     * Html version of assertXmlStringEqualsXmlString
     *
     * @see \PHPUnit_Framework_Assert::assertXmlStringEqualsXmlString
     *
     * @param string $expectedXml
     * @param string $actualXml
     * @param string $message
     */
    public function assertHtmlStringEqualsHtmlString($expectedXml, $actualXml, $message = '')
    {
        $expected                     = new \DOMDocument();
        $expected->preserveWhiteSpace = false;
        $expected->loadHTML($expectedXml);

        $actual                     = new \DOMDocument();
        $actual->preserveWhiteSpace = false;
        $actual->loadHTML($actualXml);

        $this->assertEquals($expected, $actual, $message);
    }
}
