<?php

$GLOBALS['BE_MOD']['content']['distributors'] = array
(
  'tables'           => array('tl_distributors'),
  'icon'             => 'system/modules/distributor_map/assets/be/icon.gif',
  'stylesheet'       => 'system/modules/distributor_map/assets/be/style.css'
);

/**
 * Front end modules
 */


array_insert($GLOBALS['FE_MOD'], 4, array
(
    'Distributors' => array
    (
        'DistributorList'   => 'ModuleDistributorsList'
    )
));



/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'calendars';
