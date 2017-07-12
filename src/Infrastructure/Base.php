<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\CacheControl\Infrastructure;

use Database;
use Files;
use Netzmacht\Contao\CacheControl\PageCache;

/**
 * Base infrastructure class providing access to page cache service.
 *
 * @package Netzmacht\Contao\CacheControl
 */
class Base
{
    /**
     * Page cache service.
     *
     * @var PageCache
     */
    private $service;

    /**
     * Get the page cache service.
     *
     * @return PageCache
     */
    public function service()
    {
        if ($this->service === null) {
            // Create the Contao stack. Why isn't is part of system/initialize.php?
            if (TL_MODE === 'FE') {
                \FrontendUser::getInstance();
            } else {
                \BackendUser::getInstance();
            }

            $this->service = new PageCache(Database::getInstance(), Files::getInstance());
        }

        return $this->service;
    }
}
