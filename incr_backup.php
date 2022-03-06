<?php

/**
 * @package IncrBackup
 *
 */

/*
Plugin Name: Incremental Backup
Plugin URI: http://plugin.url.com
Description: Incremental Backup in wasabi storage
Version: 1.0.0
Author: creepysta
Author URI: https://github.com/creepysta
License: MIT
Text Domain: incr_backup
*/


defined("ABSPATH") or die("Hope you can't access this file");

class IncrBackup {
    function __construct(string $x) {
        echo $x;
    }
}

if ( class_exists( "IncrBackup" ) ) {
    $incrBackup = new IncrBackup( "TEST" );
}


function recur(string $path, array $files) {
    if(is_dir($path)) {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileinfo) {
            $nowPath = $path . $dir
            if(is_dir($nowPath)) {}
        }
    } else {

    }
}


