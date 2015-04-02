<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
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
     */
    public function registerPageCacheKey($cacheKey)
    {
        global $objPage;

        // $objPage is only available when the hook is triggered by the FrontendTemplate::addToCache method.
        // If it's triggered by outputFromCache it's not available. Make use of this knowledge.
        if ($objPage) {
            $preparedKey = $cacheKey;

            // Mobile key is usually added after the hook. So add it here.
            if (\Input::cookie('TL_VIEW') == 'mobile'
                || (\Environment::get('agent')->mobile && \Input::cookie('TL_VIEW') != 'desktop')
            ) {
                $preparedKey .= '.mobile';
            }

            $this->service->registerCacheKey($objPage->id, md5($preparedKey));
        }

        return $cacheKey;
    }

    /**
     * Clear the database cache when being in the maintenance mode.
     *
     * Triggered in by initializeSystem hook. Todo: Find a better place to trigger it.
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
                $this->service->clearAll();
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
        $this->service->clearAll();
    }
}
