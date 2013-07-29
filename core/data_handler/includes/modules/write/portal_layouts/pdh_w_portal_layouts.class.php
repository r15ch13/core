<?php
/*
* Project:		EQdkp-Plus
* License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
* Link:			http://creativecommons.org/licenses/by-nc-sa/3.0/
* -----------------------------------------------------------------------
* Began:		2010
* Date:			$Date: 2013-01-29 17:35:08 +0100 (Di, 29 Jan 2013) $
* -----------------------------------------------------------------------
* @author		$Author: wallenium $
* @copyright	2006-2011 EQdkp-Plus Developer Team
* @link			http://eqdkp-plus.com
* @package		eqdkpplus
* @version		$Rev: 12937 $
*
* $Id: pdh_w_portal_layouts.class.php 12937 2013-01-29 16:35:08Z wallenium $
*/

if(!defined('EQDKP_INC')) {
	die('Do not access this file directly.');
}

if(!class_exists('pdh_w_portal_layouts')) {
	class pdh_w_portal_layouts extends pdh_w_generic {
		public static function __shortcuts() {
		$shortcuts = array('pdh', 'db', 'pfh', 'user', 'time',  'bbcode'=>'bbcode', 'embedly'=>'embedly');
		return array_merge(parent::$shortcuts, $shortcuts);
	}

		public function __construct() {
			parent::__construct();
		}

		public function delete($id) {
			$this->db->query("DELETE FROM __portal_layouts WHERE id = '".$this->db->escape($id)."'");
			$this->pdh->enqueue_hook('portal_layouts_update');
		}
		
		public function add($strName, $arrBlocks, $arrModules){

			$blnResult = $this->db->query("INSERT INTO __portal_layouts :params", array(
				'name' 			=> $strName,
				'blocks'		=> serialize($arrBlocks),
				'modules'		=> serialize($arrModules),
			));
			
			$id = $this->db->insert_id();
			
			if ($blnResult){		
				$this->pdh->enqueue_hook('portal_layouts_update');
				return $id;
			}
			
			return false;
		}
		
		public function update($id, $strName, $arrBlocks, $arrModules){
			
			$blnResult = $this->db->query("UPDATE __portal_layouts SET :params WHERE id=?", array(
				'name' 			=> $strName,
				'blocks'		=> serialize($arrBlocks),
				'modules'		=> serialize($arrModules),
			), $id);
						
			if ($blnResult){
				$this->pdh->enqueue_hook('portal_layouts_update');
				return $id;
			}
			
			return false;
		}
		
		
	}
}
?>