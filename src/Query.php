<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\CacheControl;


class Query
{
    const CREATE_PAGE_CACHE_ENTRY = 'INSERT INTO tl_page_cache %s';

    const FIND_PAGE_CACHE_KEY = 'SELECT id AS COUNT FROM tl_page_cache WHERE pid=? AND cacheKey=?';

    const FIND_PAGE_CACHE_ENTRIES = 'SELECT * FROM tl_page_cache WHERE pid=?';

    const FIND_ALL_CACHE_ENTRIES = 'SELECT * FROM tl_page_cache WHERE';

    const UPDATE_PAGE_CACHE_ENTRY = 'UPDATE tl_page_cache %s WHERE id=?';

    const REMOVE_PAGE_ENTRIES = 'DELETE FROM tl_page_cache WHERE id IN (%s)';

    const REMOVE_ALL_ENTRIES = 'TRUNCATE TABLE tl_page_cache';

    public static function removeEntries($entries)
    {
        return sprintf(
            static::REMOVE_PAGE_ENTRIES,
            implode(',', $entries)
        );
    }
}
