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

$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = [\Pdir\ContaoStickyFooterBundle\EventListener\ParseBackendTemplateListener::class, '__invoke'];
if (TL_MODE == 'BE')
{
    $GLOBALS['TL_CSS'][] = 'bundles/pdircontaostickyfooter/sticky-footer.scss|static';
}
