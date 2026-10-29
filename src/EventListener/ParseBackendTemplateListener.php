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

            $buffer = $this->addDebugClass($buffer);
        }

        return $buffer;
    }

    private function addDebugClass(string $buffer): string
    {
        // Match the opening body tag, skipping over quoted attribute values
        // so that e.g. Stimulus actions like "click->foo#bar" do not end it.
        $result = preg_replace_callback(
            '/<(body)\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>/i',
            function (array $matches): string {
                $hasClass = false;

                // Walk the attributes one by one, so a "class=" inside another
                // attribute's value is never mistaken for the class attribute.
                $attributes = preg_replace_callback(
                    '/(\s+class\s*=\s*)("[^"]*"|\'[^\']*\'|[^\s"\'>]+)|\s+[^\s=>]+(?:\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s"\'>]+))?/i',
                    function (array $attribute) use (&$hasClass): string {
                        if (empty($attribute[1]) || $hasClass) {
                            return $attribute[0];
                        }

                        $hasClass = true;

                        return $attribute[1].$this->prependDebugClass($attribute[2]);
                    },
                    $matches[2],
                );

                if (null === $attributes) {
                    return $matches[0];
                }

                if (!$hasClass) {
                    $attributes = rtrim($attributes).' class="debug"';
                }

                return '<'.$matches[1].$attributes.'>';
            },
            $buffer,
            1,
        );

        return $result ?? $buffer;
    }

    private function prependDebugClass(string $value): string
    {
        $quote = '"';

        if (\in_array($value[0], ['"', "'"], true)) {
            $quote = $value[0];
            $value = substr($value, 1, -1);
        }

        $classes = preg_split('/\s+/', trim($value), -1, PREG_SPLIT_NO_EMPTY);

        if (!\in_array('debug', $classes, true)) {
            array_unshift($classes, 'debug');
        }

        return $quote.implode(' ', $classes).$quote;
    }
}
