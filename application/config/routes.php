<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['about'] = 'Page/about';
$route['privacy'] = 'Page/privacy';
$route['sitemap.xml'] = 'Sitemap/index';
$route['stat/(:any)'] = 'Shortener/checkURLStat/$1';
$route['(:any)'] = 'Shortener/accessLongURL/$1';

# API
$route['api/v1/shortener/_process'] = 'Shortener/processUrl';
$route['api/v1/shortener/_get_statistics'] = 'Shortener/getURLData';
$route['api/v1/shortener/_get_click_stats'] = 'Shortener/getClickStat';
$route['api/v1/shortener/_get_referrer_stats'] = 'Shortener/getReferrerStat';
$route['api/v1/shortener/_get_browser_stats'] = 'Shortener/getBrowserStat';
$route['api/v1/shortener/_get_platform_stats'] = 'Shortener/getPlatformStat';
$route['api/v1/shortener/_get_location_stats'] = 'Shortener/getLocationStat';
$route['api/v1/shortener/_upload_logo'] = 'Shortener/uploadCustomLogo';
$route['api/v1/xss/_get_csrf_data'] = 'App/getCsrfData';

$route['default_controller'] = 'App/index';
$route['404_override'] = 'Error404';
$route['translate_uri_dashes'] = TRUE;
