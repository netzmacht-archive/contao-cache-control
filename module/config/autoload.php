<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

// Uncomment if install it manually.
ClassLoader::addClasses(
    array(
        'Netzmacht\Contao\CacheControl\Infrastructure\Base'      => 'system/modules/cache-control/classes/src/Infrastructure/Base.php',
        'Netzmacht\Contao\CacheControl\Infrastructure\DcaHelper' => 'system/modules/cache-control/classes/src/Infrastructure/DcaHelper.php',
        'Netzmacht\Contao\CacheControl\Infrastructure\Hooks'     => 'system/modules/cache-control/classes/src/Infrastructure/Hooks.php',
        'Netzmacht\Contao\CacheControl\PageCache'                => 'system/modules/cache-control/classes/src/PageCache.php',
        'Netzmacht\Contao\CacheControl\Query'                    => 'system/modules/cache-control/classes/src/Query.php',
    )
);
