<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * made for Contao Open Source CMS
 * Copyright (C) 2013 Fakir Informatik
 *
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    News
 * @license    LGPL
 * @filesource
 */


/**
 * Class ModuleNewsList
 *
 * Front end module "news list".
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class ModuleDistributorsList extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'modules/mod_distributors_list';
        

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### Distributors LIST ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

        
		return parent::generate();
	}


	/**
	 * Generate module
	 */
	public function compile()
	{
		$this->Import('Database');
        
        
        $plz = $this->Input->post('plz');
        
        
        if ($plz) {
           $verkaufsstellen = Verkaufsstellen::getInstance();
           //$coords;
           $this->Template->Verkaufsstellen  = $verkaufsstellen->findByPlz($plz, "50000","Deutschland", $coords);
           $this->Template->gesuchtePLZ = $plz;
           $this->Template->MapCenter = $coords;
           
           
           
         $this->Database->prepare('INSERT INTO tl_verkaufsstellen_suchelog (keyword, tstamp) VALUES (?, ?)')
                    ->execute($plz,time());
              $res =$this->Database->prepare('SELECT * FROM tl_verkaufsstellen_suchelog')
                    ->execute();       
        
                                  
                              
         }
        else {
                    $this->Template->MapCenter = array('lat' => 48.9489, 'lng' => 9.43311);
        }   
        return;
		// $coords = $this->geocode($plz, null, $strLang = 'de', $country);
		/*		if($coords)
				{
					// $varValue = $coords['lat'] . ',' . $coords['lng'];
					$objGeo = $this->Database->prepare($sql)
								   ->limit(1)
								   ->execute($coords['lat'], 
										     $coords['lng'],
										     $dc->id);

					
					
				}*/
				
	}
    public function sortOutProtected () {
        
    }
}

?>