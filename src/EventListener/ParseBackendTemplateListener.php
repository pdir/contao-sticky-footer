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

namespace Pdir\ContaoStickyFooterBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\System;

#[AsHook('parseBackendTemplate')]
class ParseBackendTemplateListener
{
    public function __invoke(string $buffer, string $template): string
    {
        if ('be_main' === $template) {
            $container = System::getContainer();

            // Check if debug mode is enabled.
            if (!$container->getParameter('kernel.debug'))
            {
                return $buffer;
            }

            if(str_contains($buffer, '<body id="top">')) {
                // Main backend view
                $buffer = str_replace('<body id="top">', '<body id="top" class="debug">', $buffer);
            } else {
                // Body already has classes, e.g. popup
                $buffer = str_replace('<body id="top" class="', '<body id="top" class="debug ', $buffer);
            }
        }

        return $buffer;
    }
}
