<?php
/*
Plugin Name: ITP Cookie Saver
Description: This Plugin converts javascript cookies to server cookies. This is important as Safari and other browser tend to limit the cookie lifetime for tracking and javascript cookies, e.g. ITP 2.1.
Author: Nikel Schubert
Version: 1.2.1
Author URI: https://nikel.co/
Text Domain: itp-cookie-saver
License: GPL3

ITP Cookie Saver is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

ITP Cookie Saver is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with ITP Cookie Saver. If not, see {License URI}.
 */

define('NSC_ics_PLUGINPATH', plugin_dir_path(__FILE__));
define('NSC_ics_PLUGINURL', plugins_url() . "/" . basename(dirname(__FILE__)));

require dirname(__FILE__) . "/class/class-de-nikelschubert-nsc_ics.php";
require dirname(__FILE__) . "/class/class_nsc_ics.php";
require dirname(__FILE__) . "/class/class_nsc_ics_backend.php";
require dirname(__FILE__) . "/class/class_nsc_ics_frontend.php";

//creates admin page
$nsc_ics_backendpage = new nsc_ics_backendsettings;
$nsc_ics_backendpage->nsc_ics_executeWPactions();

add_filter("plugin_action_links_" . plugin_basename(__FILE__), array($nsc_ics_backendpage, 'nsc_ics_add_settings_link'));

//add before unload script
if (get_option("nsc_ics_beforeunload", "1") == "1" && get_option("nsc_ics_activate", false) == true) {
    $nsc_short_code = new nsc_ics_frontend;
    $nsc_short_code->nsc_ics_executeWordpressActions();
}

//save the cookies
$nsc_ics_cookiesaver = new nsc_itp_cookie_saver;
$nsc_ics_cookiesaver->nsc_ics_save_cookies();
