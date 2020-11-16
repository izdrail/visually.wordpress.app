<?php

/**
 * Plugin Name: Visually
 * Plugin URI: https://lzomedia.com
 * Description: Visually is a WP plugin that allows users to import infographics
 * Version: dev-master
 * Author: Stefan Izdrail
 * Author URI: https://lzomedia.com
 * Text Domain: visually
 * Domain Path: localization
 *
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/
use Visually\WPBones\Foundation\Plugin;

require_once __DIR__ . '/bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap the plugin
|--------------------------------------------------------------------------
|
| We need to bootstrap the plugin.
|
*/

// comodity define for text domain
define( 'VISUALLY_TEXTDOMAIN', 'visually' );

$GLOBALS[ 'Visually' ] = require_once __DIR__ . '/bootstrap/plugin.php';

if ( ! function_exists( 'Visually' ) ) {

  /**
   * Return the instance of plugin.
   *
   * @return Plugin
   */
  function Visually()
  {
    return $GLOBALS[ 'Visually' ];
  }
}
