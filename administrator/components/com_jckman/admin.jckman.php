<?php

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

// Require specific controller
// Controller

//load base classes
require_once (JPATH_COMPONENT.DS.'base'.DS.'loader.php');

//defines CKEDITOR library includes path
define('CKEDITOR_LIBRARY',JPATH_PLUGINS.DS.'editors'.DS.'jckeditor'.DS.'jckeditor'.DS.'includes'.DS.'ckeditor'); 


define('JCK_COMPONENT', JUri::root() . 'administrator/components/com_jckman');

require_once('helper.php');

if (!JFactory::getUser()->authorise('core.manage', 'com_jckman')) 
{
        return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

//load  default style sheets
$document = JFactory::getDocument();
$document->addStyleSheet( JCK_COMPONENT . '/css/header.css', 'text/css' );


jckimport('base.controller');

//register all event listeners
JCKRegisterAllEventlisetners();
$mainframe = JFactory::getApplication();


//Make sure we load in system language file for component

$lang = JFactory::getLanguage();
$component = 'com_jckman.sys';
$lang->load($component, JPATH_ADMINISTRATOR);

if(is_dir(CKEDITOR_LIBRARY))
{
	
	$controller = JRequest::getWord('controller','cpanel');
}	
else
{	
	$controller = 'cpanel';
	$mainframe->enqueueMessage("COM_JCKMAN_NO_DETECT_EDITOR_MSG");
}	
// Require specific controller if requested




jckimport('controllers.' . $controller );

//require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');



if($controller == "Install")
{

	require_once (JPATH_COMPONENT.DS.'controllers'.DS. 'install.php');
 
	$ext = JRequest::getWord('type');
	$subMenus = array( 'COM_JCKMAN_SUBMENU_UNINSTALL_PLUGINS' => 'plugin', 'COM_JCKMAN_SUBMENU_UNINSTALL_LANGUAGES' => 'language' );
	addCustomSubMenus($controller,$ext,$subMenus,'manage','Post');
    
	//load language file,
	
	$lang = JFactory::getLanguage();
	$lang->load('com_installer',JPATH_ADMINISTRATOR);
	
	// Create the controller
	jimport('joomla.client.helper');
	$controller = JController::getInstance('Installer',array(
	'base_path' =>  dirname( __FILE__ )));
	
	//var_dump(JRequest::getWord('task'));
	//var_dump($controller);
	//die();	
	
	
	 if(!is_a($controller,'InstallerController'))
	 {
	 	$mainframe->setUserState('com_installer.redirect_url', 'index.php?option=com_jckman&controller=Install');
	 }
	$controller->execute(JRequest::getCmd( 'task' ));
	$controller->redirect();

}
else 
{
    // main helper class
	jckimport('helper');
	// global include classes
	jckimport('parameter.parameter');
	jckimport('html.html');
	
	$ext = JRequest::getWord('type');
	$subMenus = array('COM_JCKMAN_SUBMENU_PLUGIN_NAME'=> 'list','COM_JCKMAN_SUBMENU_INSTALL_NAME'=> 'Install','COM_JCKMAN_SUBMENU_LAYOUT_NAME'=> 'toolbars','COM_JCKMAN_SUBMENU_IMPORT_NAME' =>'import');
		
	addCustomSubMenus($controller,$ext,$subMenus,'');
	jimport( 'joomla.application.component.controller' );
	// Create the controller
	//$classname    = $controller. 'Controller';
	$controller   =  JController::getInstance($controller);//new $classname( );
	$controller->execute(JRequest::getCmd( 'task' ));
	$controller->redirect();
}

function addCustomSubMenus($controller,$type, $subMenus, $task = '',$action = 'Get')
{
	$canDo = JCKHelper::getActions();
	
	switch($action)
	{
		case 'Post' :
			JSubMenuHelper::addEntry(JText::_( $controller ), '#" onclick="javascript:document.adminForm.view.value=\''.$controller.'\'; document.adminForm.task.value=\'\';Joomla.submitbutton(\'\');', !in_array( $type, $subMenus));
		
			foreach ($subMenus as $name => $extension) 
			{
				if($extension == 'Install' && !$canDo->get('jckman.install'))
					continue;	
				elseif($extension == 'import' && !$canDo->get('core.edit'))
					continue;	
				elseif($extension == 'plugin' && !$canDo->get('jckman.uninstall'))
					continue;	
				elseif($extension == 'language' && !$canDo->get('jckman.uninstall'))
					continue;		
				JSubMenuHelper::addEntry(JText::_( $name ), '#" onclick="javascript:document.adminForm.view.value=\''.$extension.'\';Joomla.submitbutton(\''. $task.'\');', ($extension == $type));
			}
		
		break;
		default :
		
			if($type == '')
				$type = $controller;
			foreach ($subMenus as $name => $extension) 
			{
				JSubMenuHelper::addEntry(JText::_( $name ), 'index.php?option=com_jckman&controller='.$extension.'"', ($extension == $type));
			}
	}

 	
}

?>


