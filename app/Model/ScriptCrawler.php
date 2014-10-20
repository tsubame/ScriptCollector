<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('PHPCrawler', 'Vendor/PHPCrawl/libs/');
echo getcwd ();
include("../Vendor/PHPCrawl/libs/PHPCrawler.class.php");
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class ScriptCrawler extends PHPCrawler {
	
	/**
	 * 
	 */
	public function exec($url) {
		//$crawler = new MyCrawler();
		$this->setURL($url);
		$this->addContentTypeReceiveRule("#text/html#");		

		$this->go();
	}
	
	function handleDocumentInfo(PHPCrawlerDocumentInfo $PageInfo) {
		// Your code comes here!
		// Do something with the $PageInfo-object that
		// contains all information about the currently
		// received document.
		// Print the URL and the HTTP-status-Code
		echo "Page requested: ".$PageInfo->url." (".$PageInfo->http_status_code.")". "<br />";
		 
		// As example we just print out the URL of the document
		//echo $PageInfo->url."\n";
	}
}
