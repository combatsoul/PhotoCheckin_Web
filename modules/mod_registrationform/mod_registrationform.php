<?php

 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$register = mod_registrationformHelper::getregister( $params );
require( JModuleHelper::getLayoutPath( 'mod_registrationform' ) );
?>