<?php

/*
 * Contao backend toolbar bundle for Contao Open Source CMS
 *
 * Copyright (c) 2020 pdir / digital agentur // pdir GmbH
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

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\System;

/**
 * @Hook("parseBackendTemplate")
 */
class ParseBackendTemplateListener
{
    public function __invoke(string $buffer, string $template)
    {
        if ('be_main' === $template) {
            $container = System::getContainer();

            // Check if debug mode is enabled.
            if (!$container->getParameter('kernel.debug'))
            {
                return $buffer;
            }

            if(str_contains($buffer, '<body id="top">')) {
                // Contao 5
                $buffer = str_replace('<body id="top">', '<body id="top" class="debug">', $buffer);
            } else {
                // Contao 4 and Contao 5 popup
                $buffer = str_replace('<body id="top" class="', '<body id="top" class="debug ', $buffer);
            }
        }

        return $buffer;
    }
}