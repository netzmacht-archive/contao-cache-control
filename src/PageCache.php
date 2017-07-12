<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\CacheControl;

use Database;
use Database\Result;
use Files;

/**
 * PageCache service class.
 *
 * @package Netzmacht\Contao\CacheControl
 */
class PageCache
{
    /**
     * The database connection.
     *
     * @var Database
     */
    private $database;

    /**
     * The file system.
     *
     * @var Files
     */
    private $fileSystem;

    /**
     * Construct.
     *
     * @param Database $database   The database connection.
     * @param Files    $fileSystem The file system.
     */
    public function __construct(Database $database, Files $fileSystem)
    {
        $this->database   = $database;
        $this->fileSystem = $fileSystem;
    }

    /**
     * Clear the cache for a specific page.
     *
     * @param int $pageId The page id.
     *
     * @return int
     */
    public function clearPage($pageId)
    {
        $result = $this->database
            ->prepare(Query::FIND_PAGE_CACHE_ENTRIES)
            ->execute($pageId);

        return $this->clearCache($result);
    }

    /**
     * Clear the whole cache.
     *
     * @param bool $files If true also the files are deleted.
     *
     * @return void
     */
    public function clearAll($files = false)
    {
        if ($files) {
            $result = $this->database->query(Query::FIND_ALL_CACHE_ENTRIES);
            $this->clearCache($result);
        }

        $this->database->query(Query::REMOVE_ALL_ENTRIES);
    }

    /**
     * Register a page cache key.
     *
     * @param int    $pageId   The page id.
     * @param string $cacheKey The current cache key.
     *
     * @return void
     */
    public function registerCacheKey($pageId, $cacheKey)
    {
        $result = $this->database
            ->prepare(Query::FIND_PAGE_CACHE_KEY)
            ->limit(1)
            ->execute($pageId, $cacheKey);

        if ($result->numRows < 1) {
            $this->database
                ->prepare(Query::CREATE_PAGE_CACHE_ENTRY)
                ->set(
                    array(
                        'pid'      => $pageId,
                        'tstamp'   => time(),
                        'cacheKey' => $cacheKey
                    )
                )
                ->execute();
        }
    }

    /**
     * Count page cache entries.
     *
     * @param int $pageId Page id.
     *
     * @return mixed|null
     */
    public function countPageCacheEntries($pageId)
    {
        $result = $this->database->prepare(Query::FIND_PAGE_CACHE_ENTRIES)->execute($pageId);

        return $result->numRows;
    }

    /**
     * Clear the cache for a given database result and return the number of affected files.
     *
     * @param Result $result The database result.
     *
     * @return int
     */
    private function clearCache($result)
    {
        $delete = array();

        while ($result->next()) {
            $cacheFile = sprintf('system/cache/html/%s/%s.html', substr($result->cacheKey, 0, 1), $result->cacheKey);
            $this->fileSystem->delete($cacheFile);

            $delete[] = $result->id;
        }

        if ($delete) {
            $result = $this->database->execute(Query::removeEntries($delete));

            return $result->affectedRows;
        }

        return 0;
    }
}
