<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved
 * @filesource
 *
 */

$GLOBALS['TL_HOOKS']['generatePage'][] = [
    'netzmacht.contao_cache_control.listener.add_page_tags',
    'onGeneratePage'
];
