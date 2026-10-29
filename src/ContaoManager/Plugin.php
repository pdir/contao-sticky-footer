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

namespace Pdir\ContaoStickyFooterBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Pdir\ContaoStickyFooterBundle\PdirContaoStickyFooterBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * @return array
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(PdirContaoStickyFooterBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
