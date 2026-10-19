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
