<?php
/******************************
 * EQDKP PLUGIN: PLUSkernel
 * (c) 2007 by EQDKP Plus Dev Team
 * originally written by S.Wallmann
 * http://www.eqdkp-plus.com
 * ------------------
 * updates.php
 * Start: 2006 
 * $Id$
 ******************************/

define('EQDKP_INC', true);
$eqdkp_root_path = '../';
include_once($eqdkp_root_path . 'common.php');
include_once('include/db.class.php');
$reset = false;

// the language include part
global $user, $eqdkp;
		// Set up language array
		if ( (isset($user->data['user_id'])) && ($user->data['user_id'] != ANONYMOUS) && (!empty($user->data['user_lang'])) )
    {
    	$lang_name = $user->data['user_lang'];
		}else{
			$lang_name = $eqdkp->config['default_lang'];
		}
		$lang_path = $eqdkp_root_path.'pluskernel/language/'.$lang_name.'/';
		include($lang_path . 'lang_main.php');
// end of language part

include('include/update.class.php');
include('include/init.class.php');

$update = new UpdateCheck(
						EQDKPPLUS_VCHECKURL,
						$eqdkpplus_vcontrol,
						array('Security Update' => 'red'),
						EQDKPPLUS_VERSION
					);
$page = new InitPlus();

echo $page->Header($eqdkp_root_path);

if($user->check_auth('a_config_man', false)){
	if ($_GET['reset'] == 'true'){
		$update->ResetUpdater('true');
		$_GET['reset'] = 'false';
	}

	echo $update->UpdateChecker();
}else{
	echo 'no Permission!';
}
?>
