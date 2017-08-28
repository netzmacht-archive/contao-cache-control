<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\CacheControl\Listener;

use Contao\PageModel;
use FOS\HttpCache\ResponseTagger;

/**
 * Class PageResponseTaggerListener
 *
 * @package Netzmacht\Contao\CacheControl\Listener
 */
class AddPageTagsListener
{
    /**
     * @var ResponseTagger
     */
    private $responseTagger;

    /**
     * PageResponseTaggerListener constructor.
     *
     * @param ResponseTagger $responseTagger
     */
    public function __construct(ResponseTagger $responseTagger = null)
    {
        $this->responseTagger = $responseTagger;
    }

    /**
     * Add Tags to the
     * @param PageModel $pageModel
     */
    public function onGeneratePage(PageModel $pageModel)
    {
        if ($this->responseTagger) {
            $this->responseTagger->addTags(['page', 'page-' . $pageModel->id]);
        }
    }
}
