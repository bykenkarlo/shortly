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
$route['privacy-terms'] = 'Page/terms';
$route['login'] = 'Page/login';
$route['logout'] = 'Page/logout';
$route['account'] = 'Page/dashboard';
$route['blog'] = 'Page/blog';
$route['sitemap.xml'] = 'Sitemap/index';
$route['category/(:any)'] = 'Page/category/$1';
$route['tags/(:any)'] = 'Page/tags/$1';
$route['draft/(:any)'] = 'Page/draft/$1';
$route['stat/(:any)'] = 'Shortener/checkURLStat/$1';
$route['(:any)-'] = 'Shortener/checkURLStat/$1';
$route['(:any)'] = 'Shortener/accessLongURL/$1';

#ACCOUNT 
$route['account/dashboard'] = 'Page/dashboard';
$route['account/url-list'] = 'Page/urlList';
$route['account/blog'] = 'Page/blogList';
$route['account/blog/new'] = 'Page/newBlog';
$route['account/blog/edit/(:any)'] = 'Page/editBlog/$1';

#BLOG
$route['blog/edit/(:any)'] = 'Page/editBlog/$1';
$route['article/(:any)'] = 'Page/article/$1';
$route['api/v1/blog/_add_category'] = 'Blog/addCategory';
$route['api/v1/blog/_get_category'] = 'Blog/getCategory';
$route['api/v1/blog/_delete_category'] = 'Blog/deleteCategory';
$route['api/v1/blog/_add_blog'] = 'Blog/addBlog';
$route['api/v1/blog/_get_list'] = 'Blog/showBlogList';
$route['api/v1/blog/_update_article_status'] = 'Blog/updateArticleStatus';
$route['api/v1/blog/_update_blog'] = 'Blog/updateBlog';
$route['api/v1/blog/_remove_tag'] = 'Blog/removeTag';
$route['api/v1/blog/_add_tag'] = 'Blog/addTag';
$route['api/v1/blog/_update_image'] = 'Blog/updateImage';
$route['api/v1/blog/_delete_article'] = 'Blog/deleteArticle';
$route['api/v1/blog/_search_article'] = 'Blog/searchBlogArticle';
$route['api/v1/blog/_check_article'] = 'Blog/checkArticle';
$route['api/v1/blog/_add_image'] = 'Blog/uploadImage';

# IMAGES
$route['api/v1/images/_get_list'] = 'Blog/getImages';


# Article 
$route['api/v1/article/_get_data'] = 'Blog/getArticleDataJS';
$route['api/v1/article/_get_blog_category'] = 'Blog/getCategoryForPageJS';
$route['api/v1/article/_get_blog_tags'] = 'Blog/getArticleTagForPageJS';

# LOGIN
$route['api/v1/account/_login'] = 'Login/loginProcess';

# Statistics
$route['api/v1/statistics/_website_stat_chart'] = 'Statistics/getWebsiteStatsChart';
$route['api/v1/statistics/_website_stats'] = 'Statistics/getWebsiteStats';
$route['api/v1/statistics/_lending_bussiness_stats'] = 'Statistics/getLendingBussinessStats';


# API
$route['api/v1/shortener/_process'] = 'Shortener/processUrl';
$route['api/v1/shortener/_get_statistics'] = 'Shortener/getURLData';
$route['api/v1/shortener/_get_click_stats'] = 'Shortener/getClickStat';
$route['api/v1/shortener/_get_referrer_stats'] = 'Shortener/getReferrerStat';
$route['api/v1/shortener/_get_browser_stats'] = 'Shortener/getBrowserStat';
$route['api/v1/shortener/_get_platform_stats'] = 'Shortener/getPlatformStat';
$route['api/v1/shortener/_get_location_stats'] = 'Shortener/getLocationStat';
$route['api/v1/shortener/_upload_logo'] = 'Shortener/uploadCustomLogo';
$route['api/v1/shortener/_customize_url'] = 'Shortener/customizeUrl';
$route['api/v1/shortener/_change_status'] = 'Shortener/changeStatus';
$route['api/v1/account/_url_list'] = 'Account/getURLList';

$route['api/v1/email/_get'] = 'Shortener/getEmailAddress';
$route['api/v1/xss/_get_csrf_data'] = 'App/getCsrfData';
$route['api/v1/_website_guest'] = 'Page/newWebsiteVisits';

$route['default_controller'] = 'App/index';
$route['404_override'] = 'Error404';
$route['translate_uri_dashes'] = TRUE;
