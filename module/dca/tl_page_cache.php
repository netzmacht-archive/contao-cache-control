<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

$GLOBALS['TL_DCA']['tl_page_cache'] = array
(
    'config' => array
    (
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'ptable'           => array('tl_page'),
        'closed'           => true,
        'notEditable'      => true,
        'notDeletable'     => true,
        'sql'              => array
        (
            'keys' => array
            (
                'id'    => 'primary',
            )
        ),
    ),

    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('pid'),
            'panelLayout'             => 'search,limit',
            'flag'                    => 1,
        ),
        'label' => array
        (
            'fields'                  => array('pid', 'tstamp'),
            'format'                  => '%s <span class="tl_gray">[%s]</span>'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            ),
        ),
        'operations' => array
        (
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_leaflet_map']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
        )
    ),

    'fields' => array
    (
        'id'     => array
        (
            'sql'       => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql'       => "int(10) unsigned NOT NULL default '0'"
        ),
        'cacheKey' => array
        (
            'sql'       => "varchar(32) NOT NULL default ''"
        ),
    )
);
