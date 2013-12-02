<?php
/**
  * @version     1.0 +
  * @package       Open Source Free Software
  * @author        Open Source Excellence (R) {@link  http://www.opensource-excellence.com}
  * @author        Created on 28-May-2012
  * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
  *
  *
  *  This program is free software: you can redistribute it and/or modify
  *  it under the terms of the GNU General Public License as published by
  *  the Free Software Foundation, either version 3 of the License, or
  *  (at your option) any later version.
  *
  *  This program is distributed in the hope that it will be useful,
  *  but WITHOUT ANY WARRANTY; without even the implied warranty of
  *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  *  GNU General Public License for more details.
  *
  *  You should have received a copy of the GNU General Public License
  *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
  *  @Copyright Copyright (C) 2010- Open Source Excellence (R)
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * @Name        Drag n Drop Admin Plugin
 * @Author      Theme Joomla Pro Extensions
 * @URL         http://www.themejoomla.com
 * @package     Theme Joomla Pro Extensions Drag n Drop Admin Plugin for Joomla! (1.5.x) and higher versions
 * @subpackage	Theme Joomla Pro Extensions Drag n Drop Admin Plugin
 * @copyright   Copyright (C) 2008-2020 Theme Joomla, Site Source Solution. All rights reserved. E & OE
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
jimport( 'joomla.plugin.plugin' );

class plgSystemplg_osedraganddrop extends JPlugin {

  /**
   * Constructor
   *
   * For php4 compatibility we must not use the __constructor as a constructor for plugins
   * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
   * This causes problems with cross-referencing necessary for the observer design pattern.
   *
   * @access	protected
   * @param	object	$subject The object to observe
   * @param 	array   $config  An array that holds the plugin configuration
   * @since	1.0
   */
  function plgSystemplg_osedraganddrop( &$subject, $config ) {
    parent::__construct( $subject, $config );
  }
  function onAfterInitialise() {
  	$mainframe= JFactory :: getApplication();
		// Dont run in admin
	if($mainframe->isAdmin() == false) {
			return; 
	}
  	jimport('joomla.version');
    $version            = new JVersion();
    $plugin             =& JPluginHelper::getPlugin('system', 'plg_osedraganddrop');
    $application        =& JFactory::getApplication();
    $params             = $this->params;
    $option             = JRequest::getVar('option', 'none');
    $format             = JRequest::getVar('format', '');
    $include_components = ",com_content,com_sections,com_categories,com_frontpage,com_menus,com_banners,com_contact,com_newsfeeds,".
                          "com_weblinks,com_comprofiler,com_virtuemart,com_modules,com_plugins,com_templates,com_kupo,com_kuposlidesbase".
                          $params->get('include_components');
    /*
      To get the DnD Admin Plugin to work with Community Builder, open up:
      [site]/administrator/components/com_comprofiler/admin.comprofiler.html.php
      and replace the function on line 27 of with the following:
      ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
      function cbsaveorder( n ) {
        jQuery("table.adminlist thead th a").each(function(index) {
          var str= $(this).href;
          var patt=/[removed]cbsaveorder/;
          var patt2=/d+/;
          if(patt.test(str)) {
            n = patt2.exec&#40;str&#41;;
          }
        });
        jQuery("table.adminlist tbody tr td input[name=order[]]").each(function(index) {
          $(this).value = index+1;
        });
        cbcheckAll_button( n );
        submitform('<?php echo addslashes( $task ); ?>');
      }
      ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     */
    if( ( $format <> 'raw' and $application->isAdmin() ) and strpos( $include_components, $option) > 0 and JRequest::getVar('task') <> 'edit' ) {
      JHTML::_('behavior.mootools');
      $document    =& JFactory::getDocument();
      $uri         =& JURI::getInstance();
      $table_class = $params->get('table_class', 'adminlist' );
      $oddrow      = $params->get('oddrow', '#800000' );
      $evenrow     = $params->get('evenrow', '#333333' );
      $show_arrows = $params->get('show_arrows', 1 );
      $show_arrows_txt = $show_arrows == 1? "": "td.order span {position: absolute; top: -100px; left: -100px; z-index: -100; display: none; width: 0px; height: 0px;}";
      $extra_path  = $original_order_value_txt = "";
      if( $version->isCompatible( '1.6.0' ) ) {
        $extra_path = 'plg_osedraganddrop/';
        $original_order_value_txt = 'try{ document.adminForm.original_order_values.value = "99,999,9999,2222,9991,91234,999"; } catch(err) {}';
      }
      if( $params->get('use_jquery') == 1 ) $document->addScript("../plugins/system/{$extra_path}plg_osedraganddrop/jquery.min.js");
      $css = '
        table.'.$table_class.' tbody tr.tjDragClass td { color: #999; font-weight: bold; font-style: italic; }
        table.'.$table_class.' tbody tr.tjDragClass td a:link { font-style: italic; font-weight: bold; color: #999; }
        table.'.$table_class.' tbody tr td a:link { color: '.$oddrow.' }
        table.'.$table_class.' tbody tr.row1  td a:link { color: '.$evenrow.' }
       ';
      //$document->addStyleDeclaration( "$css\n$show_arrows_txt" );
      $document->addCustomTag( "
      <style type=\"text/css\">
        $css\n
        $show_arrows_txt
      </style>
      " );
      $document->addScript("../plugins/system/{$extra_path}plg_osedraganddrop/jquery.tablednd.js");
      $js = '
        jQuery.noConflict();
        jQuery(document).ready(function() {
        	try{
        	  jQuery("table.'.$table_class.'").tableDnD({
              onDragClass: "tjDragClass",
            });
        	} catch( err ) {}
        });
        function saveorder(n) {
          task = "saveorder";
          jQuery("table.'.$table_class.' thead th a").each(function(index) {
            var str= $(this).href;
            var patt=/javascript:saveorder/;
            var patt2=/\d+/;
            var patt3=/\\\'[a-z.]+\\\'/;
            if(patt.test(str)) {
              n = patt2.exec(str);
              task = (patt3.exec(str)).toString();
            }
          });
          task = task.replace(/\'/g,"");
          jQuery(\'table.'.$table_class.' tbody tr td input[name="order[]"]\').each(function(index) {
            $(this).value = index+1;
          });
          '.$original_order_value_txt.'
          checkAll_button( n, task );
        }
      ';
      $document->addScriptDeclaration( $js );
    }
  }
}

?>