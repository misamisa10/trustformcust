<?php
/*
Plugin Name: Trust Form Custom 応募用
Plugin URI: http://54.64.83.95/
Description: 応募用TrustForm用プラグイン
Author: Misato Mochizuki
Version: 0.1
Author URI: http://54.64.83.95/
*/

class TrustFormCustom {
	function __construct(){
		add_action('admin_menu', array($this, 'add_pages'));
	}
	function add_pages(){
		add_menu_page('応募フォーム設定','応募フォーム設定','level_8', __FILE__, array($this,'show_text_option_page'), '', 26);
	}
	function show_text_option_page(){
		require_once('trust-form-add.php');
	}
}
$trustformcustom = new TrustFormCustom;


	require_once('trust-form-top.php');
?>
