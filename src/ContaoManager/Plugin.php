<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\CacheControl\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use FOS\HttpCacheBundle\FOSHttpCacheBundle;
use Netzmacht\Contao\CacheControl\NetzmachtContaoCacheControlBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;

/**
 * Class Plugin
 *
 * @package Netzmacht\Contao\CacheControl\ContaoManager
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(FOSHttpCacheBundle::class)
                ->setLoadAfter([SensioFrameworkExtraBundle::class]),
            BundleConfig::create(NetzmachtContaoCacheControlBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setLoadAfter([FOSHttpCacheBundle::class])
        ];
    }
}
