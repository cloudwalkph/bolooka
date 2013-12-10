<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

# default route
$route['default_controller'] = 'bolooka';
$route['404_override'] = 'errors/page_missing';

$route['home'] = "bolooka/home";
$route['data_uri'] = "bolooka/data_uri";
$route['pass_encode'] = "bolooka/pass_encode";
$route['pass_decode'] = "bolooka/pass_decode";
$route['ps_drop_shadow'] = "bolooka/ps_drop_shadow";
$route['ps_text_shadow'] = "bolooka/ps_text_shadow";
$route['get_user_data'] = "bolooka/get_user_data";

$route['signup'] = "signup";
$route['signup/(:any)'] = 'signup/$1';
$route['signup/(:any)/(:any)'] = 'signup/$1/$2';

$route['signin/(:any)'] = 'signin/$1';
$route['signin'] = "signin";
$route['store'] = "store";
$route['store/(:any)'] = "store/$1";

$route['preview'] = "preview";
$route['preview/(:any)'] = 'preview/$1';

$route['wall'] = "wall";
$route['wall/(:any)'] = 'wall/$1';

$route['shop/(:any)'] = 'shop/$1';
#$route['shop/(:any)/(:any)'] = 'shop/$1/$2';

$route['marketplace'] = 'bolooka/marketplace';

$route['logout'] = "logout";
$route['logout/(:any)'] = "logout/$1";

$route['dashboard'] = "dashboard";
$route['dashboard/(:any)'] = 'dashboard/$1';
$route['dashboard/(:any)/(:any)'] = 'dashboard/$1/$2';

$route['manage'] = "manage";
$route['manage/(:any)'] = 'manage/$1';
$route['manage/(:any)/(:any)'] = 'manage/$1/$2';

$route['profile'] = "profile";
$route['profile/(:any)'] = 'profile/$1';

$route['credits'] = "credits";
$route['credits/(:any)'] = 'credits/$1';

$route['settings'] = "settings";
$route['settings/(:any)'] = 'settings/$1';

$route['test'] = "test";
$route['test/(:any)'] = 'test/$1';
$route['test/(:any)/(:any)'] = 'test/$1/$2';

$route['create'] = "create";
$route['create/(:any)'] = 'create/$1';

#for activation
$route['activation'] = "activation";
$route['activation/(:any)'] = 'activation/$1';
$route['activation/(:any)/(:any)'] = 'activation/$1/$2';
$route['activation/(:any)/(:any)/(:any)'] = 'activation/$1/$2/$3';

$route['page_content'] = "page_content";

$route['multi'] = "multi";
$route['multi/(:any)'] = "multi/$1";
$route['multi/(:any)/(:any)'] = "multi/$1/$2";

# inner pages
$route['about-us'] = "bolooka/about_us";
$route['team'] = "bolooka/team";
$route['press'] = "bolooka/press";
$route['jobs'] = "bolooka/jobs";
$route['investor'] = "bolooka/investor";
$route['features'] = "bolooka/features";
$route['faq'] = "bolooka/faq";
$route['how-to'] = "bolooka/how_to";
$route['how_to'] = "bolooka/how_to";
$route['feedback'] = "bolooka/feedback";
$route['feedback/(:any)'] = "bolooka/feedback/$1";
$route['contact-us'] = "bolooka/contact_us";
$route['contact-us/(:any)'] = "bolooka/contact_us/$1";

$route['partners'] = "bolooka/partners";

# for dynamic websites
$route['(:any)'] = "bolooka/w/$1";
$route['(:any)/(:any)'] = "bolooka/w/$1/$2";
$route['(:any)/(:any)/(:any)'] = "bolooka/w/$1/$2/$3";
$route['(:any)/(:any)/(:any)/(:any)'] = "bolooka/w/$1/$2/$3/$4";

# for cart
$route['cart'] = "multi/checkout_success";

/* End of file routes.php */
/* Location: ./application/config/routes.php */