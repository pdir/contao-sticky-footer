<?php

/*
 * pdir Sticky Footer bundle for Contao Open Source CMS
 *
 * Copyright (c) 2026 pdir / digital agentur // pdir GmbH
 *
 * @package    contao-sticky-footer
 * @link       https://github.com/pdir/contao-sticky-footer
 * @license    GPL-3.0-or-later
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\ContaoStickyFooterBundle\Tests\EventListener;

use Contao\System;
use Contao\TestCase\ContaoTestCase;
use Pdir\ContaoStickyFooterBundle\EventListener\ParseBackendTemplateListener;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ParseBackendTemplateListenerTest extends ContaoTestCase
{
    protected function tearDown(): void
    {
        $this->resetStaticProperties([System::class]);

        parent::tearDown();
    }

    public function testAddsDebugClassToBody(): void
    {
        $this->setDebug(true);

        $buffer = (new ParseBackendTemplateListener())('<body id="top">', 'be_main');

        $this->assertSame('<body id="top" class="debug">', $buffer);
    }

    public function testPrependsDebugClassToExistingClasses(): void
    {
        $this->setDebug(true);

        $buffer = (new ParseBackendTemplateListener())('<body id="top" class="popup">', 'be_main');

        $this->assertSame('<body id="top" class="debug popup">', $buffer);
    }

    #[DataProvider('bodyTagProvider')]
    public function testHandlesBodyTagVariants(string $input, string $expected): void
    {
        $this->setDebug(true);

        $buffer = (new ParseBackendTemplateListener())($input, 'be_main');

        $this->assertSame($expected, $buffer);
    }

    public static function bodyTagProvider(): iterable
    {
        yield 'no id' => [
            '<body>',
            '<body class="debug">',
        ];

        yield 'class before id' => [
            '<body class="popup" id="top">',
            '<body class="debug popup" id="top">',
        ];

        yield 'single quotes' => [
            "<body id='top' class='popup'>",
            "<body id='top' class='debug popup'>",
        ];

        yield 'unquoted class' => [
            '<body id=top class=popup>',
            '<body id=top class="debug popup">',
        ];

        yield 'uppercase and extra whitespace' => [
            "<BODY\n  id=\"top\"\n  CLASS = \" popup  be \">",
            "<BODY\n  id=\"top\"\n  CLASS = \"debug popup be\">",
        ];

        yield 'greater-than sign in attribute value' => [
            '<body id="top" data-action="click->contao--foo#bar">',
            '<body id="top" data-action="click->contao--foo#bar" class="debug">',
        ];

        yield 'class inside another attribute value' => [
            '<body data-foo=" class=\'x\'" class="popup">',
            '<body data-foo=" class=\'x\'" class="debug popup">',
        ];

        yield 'debug class already present' => [
            '<body id="top" class="popup debug">',
            '<body id="top" class="popup debug">',
        ];

        yield 'similar tag name' => [
            '<bodywrap><body id="top">',
            '<bodywrap><body id="top" class="debug">',
        ];

        yield 'only first body tag' => [
            '<body id="top"><p>&lt;body&gt;</p><template><body></template>',
            '<body id="top" class="debug"><p>&lt;body&gt;</p><template><body></template>',
        ];

        yield 'no body tag' => [
            '<div id="top">',
            '<div id="top">',
        ];
    }

    public function testIgnoresBufferWithoutDebugMode(): void
    {
        $this->setDebug(false);

        $buffer = (new ParseBackendTemplateListener())('<body id="top">', 'be_main');

        $this->assertSame('<body id="top">', $buffer);
    }

    public function testIgnoresOtherTemplates(): void
    {
        $this->setDebug(true);

        $buffer = (new ParseBackendTemplateListener())('<body id="top">', 'be_login');

        $this->assertSame('<body id="top">', $buffer);
    }

    private function setDebug(bool $debug): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.debug', $debug);

        System::setContainer($container);
    }
}
