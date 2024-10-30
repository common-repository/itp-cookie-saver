<?php

if (defined('WP_UNINSTALL_PLUGIN') === false) {
    echo "no way";
    exit;
}
define('NSC_ics_PLUGINPATH', plugin_dir_path(__FILE__));
require dirname(__FILE__) . "/class/class-de-nikelschubert-nsc_ics.php";
require dirname(__FILE__) . "/class/class_nsc_ics_backend.php";

$backend = new nsc_ics_backendsettings;

$backend->deleteOptions();
