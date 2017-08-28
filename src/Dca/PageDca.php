<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015-2017 netzmacht David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Contao\CacheControl\Dca;

use Contao\Input;
use Contao\Message;
use Controller;
use FOS\HttpCacheBundle\CacheManager;

/**
 * Helper class to trigger the page cache service within Contao.
 *
 * @package Netzmacht\Contao\CacheControl
 */
class PageDca
{
    /**
     * Cache Manager.
     *
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * PageDca constructor.
     *
     * @param CacheManager $cacheManager Cache Manager.
     */
    public function __construct(CacheManager $cacheManager = null)
    {
        $this->cacheManager = $cacheManager;
    }

    /**
     * Clear page cache for a defined page.
     *
     * Triggered by the onload_callback.
     *
     * @return void
     */
    public function clearPageCache()
    {
        if (!$this->cacheManager) {
            return;
        }

        if (Input::get('clearCache') === '1') {
            $this->doClearPageCache(Input::get('id'));
            Controller::redirect(Controller::getReferer());
        }

        if (Input::get('act') === 'select' && Input::post('clearCache')) {
            $ids = (array) Input::post('IDS');

            foreach ($ids as $pageId) {
                $this->doClearPageCache($pageId);
            }

            Controller::redirect(Controller::getReferer());
        }
    }

    /**
     * Generate the clear cache button.
     *
     * @param array  $row        The data row.
     * @param string $href       The link.
     * @param string $label      The label.
     * @param string $title      The title.
     * @param string $icon       The icon.
     * @param string $attributes The attributes.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function generateButton($row, $href, $label, $title, $icon, $attributes)
    {
        $user          = \BackendUser::getInstance();
        $hasPermission = $user->hasAccess($row['type'], 'alpty') && $user->isAllowed(\BackendUser::CAN_EDIT_PAGE, $row);

        if (!$hasPermission) {
            $icon = \Image::getHtml($icon, $label, 'style="opacity:0.5;filter: gray;-webkit-filter: grayscale(100%);"');
            return $icon . ' ';
        }

        return sprintf(
            '<a href="%s" title="%s"%s>%s</a> ',
            \Backend::addToUrl($href . '&amp;id=' . $row['id']),
            $title . sprintf($GLOBALS['TL_LANG']['tl_page']['clearCacheCount']),
            $attributes,
            \Image::getHtml($icon, $label)
        );
    }

    /**
     * Generate the clear cache button for the select view.
     *
     * @param array $buttons The submit buttons.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function generateClearCacheButton($buttons)
    {
        $buttons['clearCache'] = sprintf(
            '<input type="submit" class="tl_submit" name="clearCache" accesskey="e" value="%s">',
            $GLOBALS['TL_LANG']['tl_page']['clearCache'][0]
        );

        return $buttons;
    }

    /**
     * Do the page cache clearing.
     *
     * @param int $pageId The page id.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function doClearPageCache($pageId)
    {
        $this->cacheManager->invalidateTags(['page-' . $pageId]);

        Message::add(
            sprintf($GLOBALS['TL_LANG']['tl_page']['clearCacheReset'], $pageId),
            'TL_CONFIRM'
        );
    }
}
