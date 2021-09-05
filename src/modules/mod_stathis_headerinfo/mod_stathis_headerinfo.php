<?php

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
//require_once dirname(__FILE__) . '/media/css/stylesheet.css';

$doc = JFactory::getDocument();
$doc->addStyleSheet( JUri::root() . 'modules/mod_stathis_headerinfo/media/css/stylesheet.css' );

require JModuleHelper::getLayoutPath('mod_stathis_headerinfo');