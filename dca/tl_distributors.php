<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    News
 * @license    LGPL
 * @filesource
 */


/**
 * Load tl_content language file
 */
// $this->loadLanguageFile('tl_content');

$GLOBALS['TL_LANG']['tl_distributors']['name'] = array("Name der Verkaufsstelle","");
$GLOBALS['TL_LANG']['tl_distributors']['address']  = array("Adresse","");
$GLOBALS['TL_LANG']['tl_distributors']['city']  = array("city","");
$GLOBALS['TL_LANG']['tl_distributors']['postcode'] = array("postcode","Postleitzahl aus Deutschland");
$GLOBALS['TL_LANG']['tl_distributors']['lat'] = array("Koordinate Latitude","");
$GLOBALS['TL_LANG']['tl_distributors']['lng'] = array("Koordinate Lng","");

/**
 * Table tl_news
 */
$GLOBALS['TL_DCA']['tl_distributors'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		/* 'onload_callback' => array
		(
			array('tl_news', 'checkPermission'),
			array('tl_news', 'generateFeed')
		),
		'oncut_callback' => array
		(
			array('tl_news', 'scheduleUpdate')
		),
		'ondelete_callback' => array
		(
			array('tl_news', 'scheduleUpdate')
		),
		'onsubmit_callback' => array
		(
			array('tl_news', 'adjustTime'),
			array('tl_news', 'scheduleUpdate')
		) */
		//@ToDo: Onsubmit postcode to latlong 
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('name'),
			'headerFields'            => array('name', 'jumpTo', 'protected', 'allowComments', 'makeFeed'),
			'panelLayout'             => 'filter;sort,search,limit'
		),
		
		'label' => array
		(
			'fields'                  => array('name', 'postcode'),
			'format'                  => '%s (%s)'
		),
		
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_news']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_news']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_news']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_news']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_news']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),
	

	// Palettes
	'palettes' => array
	(
	//	'__selector__'                => array('name', 'addEnclosure', 'source'),
		'default'                     => '{title_legend},name,address,postcode,city,country;{koordinaten},lat,lng;{expert},published'
	),


	// Fields
	'fields' => array
	(
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'address' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['address'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array()
		),
		'postcode' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['postcode'],
			'default'                 => $this->User->id,
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'default'				=> 	  '',
			'eval'                    => array('doNotCopy'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_distributors', 'generateCoords')
			)
		),
		'city' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['city'],
            'default'                 => '',
            'exclude'                 => true,
            'filter'                  => true,
            'sorting'                 => true,
            'inputType'               => 'text',
            'default'               =>    '',
            'eval'                    => array('doNotCopy'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),
            
        ),
        'country' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['country'],
            'default'                 => 'Deutschland',
            'exclude'                 => true,
            'filter'                  => true,
            'sorting'                 => true,
            'inputType'               => 'text',
            'default'               =>    '',
            'eval'                    => array('doNotCopy'=>true, 'mandatory'=>true, 'tl_class'=>'w50'),

        ),
		'lat' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['lat'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			
			'default'				=> 	  '',
			'eval'                    => array('tl_class'=>'w50 wizard')
		),
		'lng' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['lng'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>'w50')
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['text'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'helpwizard'=>true),
			'explanation'             => 'insertTags'
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_distributors']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'default'				=> 	  '',
			'eval'                    => array('doNotCopy'=>true)
		)
	)
);

/**
 * Class tl_news
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_distributors extends Backend
{

/**
	 * Get geo coodinates drom address
	 * @param string
	 * @return string
	 */
	function generateCoords($varValue, DataContainer $dc) 
	{
	    $this->import("DistributorGeoHelper");

        $geoHelper = $this->DistributorGeoHelper; // contao 3.1
		if ($varValue)
		{
			$postcode = $varValue;
			if ($postcode)
			{
			    $coords = $geoHelper->postcodeToCoords($postcode,$dc->country);

				if($coords)
				{
				    $distributor = new \Contao\DistributorModel();
                    $distributor->lat = $coords['lat'];
                    $distributor->lng = $coords['lng'];
                    $distributor->id = $dc->id;
                    $distributor->save();

				}
		  			  	
			}
			
		}
		
		
		return $varValue;
	}




	/**
	 * Impcity the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
	
	}
}

?>