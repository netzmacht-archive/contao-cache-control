<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\CacheControl\Infrastructure;

use Input;

/**
 * Contao hooks.
 *
 * @package Netzmacht\Contao\CacheControl\Infrastructure
 */
class Hooks extends Base
{
    /**
     * Initialize the getCacheKey hook.
     *
     * The callback is added by the initializeSystem hook so its hopefully the last callback being triggered.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function initialize()
    {
        $GLOBALS['TL_HOOKS']['getCacheKey'][] = array(
            'Netzmacht\Contao\CacheControl\Infrastructure\Hooks',
            'registerPageCacheKey'
        );
    }

    /**
     * Register a page cache key.
     *
     * @param string $cacheKey The cache key.
     *
     * @return string
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function registerPageCacheKey($cacheKey)
    {
        // $objPage is only available when the hook is triggered by the FrontendTemplate::addToCache method.
        // If it's triggered by outputFromCache it's not available. Make use of this knowledge.
        if ($GLOBALS['objPage']) {
            $preparedKey = $cacheKey;

            if ($GLOBALS['objPage']->mobileLayout > 0) {
                if (\Input::cookie('TL_VIEW') == 'mobile'
                    || (\Environment::get('agent')->mobile && \Input::cookie('TL_VIEW') != 'desktop')
                ) {
                    // Mobile key is usually added after the hook. So add it here. See. contao/core#7826.
                    $preparedKey .= '.mobile';

                } elseif (version_compare(VERSION, '3.5', '>=')) {
                    // Contao 3.5 uses desktop suffix if mobile layout is enabled.
                    $preparedKey .= '.desktop';
                }
            }

            $this->service()->registerCacheKey($GLOBALS['objPage']->id, md5($preparedKey));
        }

        return $cacheKey;
    }

    /**
     * Clear the database cache when being in the maintenance mode.
     *
     * Triggered in by initializeSystem hook.
     *
     * @return void
     */
    public function clearCacheByMaintenance()
    {
        if (TL_MODE === 'BE'
            && Input::get('do') == 'maintenance'
            && Input::post('FORM_SUBMIT') == 'tl_purge'
        ) {
            $purge = (array) Input::post('purge');

            if (isset($purge['folders']) && in_array('pages', $purge['folders'])) {
                $this->service()->clearAll();
            }
        }
    }

    /**
     * Clear the whole cache.
     *
     * Triggered by the weekly cron job.
     *
     * @return void
     */
    public function clearCacheByCron()
    {
        $this->service()->clearAll();
    }
}
