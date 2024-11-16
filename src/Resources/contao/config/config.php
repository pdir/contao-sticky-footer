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

use Contao\System;
use Pdir\ContaoStickyFooterBundle\EventListener\ParseBackendTemplateListener;
use Symfony\Component\HttpFoundation\Request;

$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = [ParseBackendTemplateListener::class, '__invoke'];
if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')))
{
    $GLOBALS['TL_CSS'][] = 'bundles/pdircontaostickyfooter/sticky-footer.css|static';
}
