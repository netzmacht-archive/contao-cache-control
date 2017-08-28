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
