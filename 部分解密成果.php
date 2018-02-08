<?php

if (!defined("IN_DISCUZ") || !defined("IN_ADMINCP")) {
	exit("Access Denied");
}

$plugin_id = "comiis_app_portal";
if (!function_exists("comiis_app_load_app_portal_data"))