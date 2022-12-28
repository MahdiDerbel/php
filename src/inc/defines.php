<?php


defined('_WEMDEV') or die;


// Global definitions
$parts = explode(DIRECTORY_SEPARATOR, JPATH_BASE);

// Defines.

define('JPATH_ROOT',          implode(DIRECTORY_SEPARATOR, $parts));
define('JPATH_TABLE', JPATH_BASE . DIRECTORY_SEPARATOR . 'tables');
define('JPATH_CONTROLLERS', JPATH_BASE . DIRECTORY_SEPARATOR . 'controllers');
define('JPATH_CORE', JPATH_ROOT . DIRECTORY_SEPARATOR . 'core');
define('JPATH_VIEWS', JPATH_ROOT . DIRECTORY_SEPARATOR . 'views');
define('JPATH_MODELS', JPATH_ROOT . DIRECTORY_SEPARATOR . 'models');
define('JPATH_ASSETS',     JPATH_ROOT . DIRECTORY_SEPARATOR . 'assets');
define('JPATH_PLUGINS',       JPATH_ROOT . DIRECTORY_SEPARATOR .'plugins');
define('JPATH_MEDIA',  JPATH_ROOT . DIRECTORY_SEPARATOR . 'media');
define('JPATH_ESPACEPRO',        JPATH_BASE . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'espacepro');
define('JPATH_SITE',         JPATH_BASE . DIRECTORY_SEPARATOR .'views' . DIRECTORY_SEPARATOR . 'site');

