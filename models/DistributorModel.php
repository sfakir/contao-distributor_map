<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Calendar
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Reads and writes calendars
 *
 * @package   Models
 * @author    Leo Feyer <https://github.com/leofeyer>
 * @copyright Leo Feyer 2005-2013
 */
class DistributorModel extends \Model
{

    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_distributor';


    /**
     * Find multiple calendars by their IDs
     *
     * @param array $arrIds     An array of IDs
     * @param array $arrOptions An optional options array
     *
     * @return \Model\Collection|null A collection of models or null if there are no calendars
     */
    public static function findMultipleByIds($arrIds, array $arrOptions=array())
    {
        if (!is_array($arrIds) || empty($arrIds))
        {
            return null;
        }

        $t = static::$strTable;

        if (!isset($arrOptions['order']))
        {
            $arrOptions['order'] = \Database::getInstance()->findInSet("$t.id", $arrIds);
        }

        return static::findBy(array("$t.id IN(" . implode(',', array_map('intval', $arrIds)) . ")"), null, $arrOptions);
    }

    /**
     * Update cat long for row for ID
     * @param $id
     * @param $lat
     * @param $long
     */
    public function updateCoords($id,$lat,$long) {

        $sql = "UPDATE tl_DistributorGeoHelper SET lat = ?,  lng = ? WHERE id=?";
        $objGeo = $this->Database->prepare($sql)
            ->limit(1)
            ->execute($lat, $long, $id);


    }
}
