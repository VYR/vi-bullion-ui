<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'welcome';
$route['admin'] = 'admin';
$route['admin/(:any)'] = 'admin';
$route['other-services'] = 'Otherservices';
$route['other-services/(:any)'] = 'Otherservices';
$route['api'] = 'api';
$route['api/(:any)'] = 'api';
$route['404_override'] = 'welcome';
$route['translate_uri_dashes'] = FALSE;


?>