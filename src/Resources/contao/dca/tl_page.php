<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

$GLOBALS['TL_DCA']['tl_page']['config']['onload_callback'][] = array(
    'Netzmacht\Contao\CacheControl\Infrastructure\DcaHelper',
    'clearPageCache'
);

$GLOBALS['TL_DCA']['tl_page']['select']['buttons_callback'][] = array(
    'Netzmacht\Contao\CacheControl\Infrastructure\DcaHelper',
    'generateClearCacheButton'
);

$GLOBALS['TL_DCA']['tl_page']['list']['operations']['clearCache'] = array
(
    'label'           => &$GLOBALS['TL_LANG']['tl_page']['clearCache'],
    'icon'            => 'system/modules/cache-control/assets/clear-cache.png',
    'href'            => 'act=show&amp;clearCache=1',
    'button_callback' => array('Netzmacht\Contao\CacheControl\Infrastructure\DcaHelper', 'generateButton'),
);
