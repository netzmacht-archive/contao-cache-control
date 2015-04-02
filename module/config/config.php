<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('Netzmacht\Contao\CacheControl\Infrastructure\Hooks', 'initialize');
$GLOBALS['TL_HOOKS']['initializeSystem'][] = array('Netzmacht\Contao\CacheControl\Infrastructure\Hooks', 'clearCacheByMaintenance');

$GLOBALS['TL_CRON']['weekly'][] = array('Netzmacht\Contao\CacheControl\Infrastructure\Hooks', 'clearCacheByCron');
