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
$route['default_controller'] = 'home';
//$route['404_override'] = 'error';
$route['404_override'] = 'MyCustom404Ctrl';
$route['translate_uri_dashes'] = FALSE;


$route['administrator'] = 'AdminLogin';
$route['teacherlogin'] = 'AdminLogin';
$route['employeelogin'] = 'AdminLogin';
$route['logout'] = 'AdminLogin/logout';
$route['logouts'] = 'Signup/Logout';
$route['signup'] = 'AuthAccess/signup_user';

$route['test_exam_list'] = 'Teacher_create_pepar/exam_list';
$route['resend/(.*)'] = 'AuthAccess/Resend_otp/$1';
$route['email_otp/(.*)'] = 'AuthAccess/emailOtp/$1';
$route['forgotpassword'] = 'AuthAccess/email_verify';
$route['teacher_management'] = 'person/index';
$route['teacher_profile'] = 'person/teacherprofile';

$route['pdf-preview'] = 'teacher_generate_paper/question_pdf';
$route['answersheet'] = 'teacher_generate_paper/answersheet_question';
$route['pdf-answersheet'] = 'teacher_generate_paper/answersheet_pdf';

$route['about-us'] = 'Home/About_us';
$route['price'] = 'Home/Price_product';
$route['buynow'] = 'Home/BuyNow';


$route['edit_teacher_pepar'] = 'Teacher_create_pepar/edit_pepar';

//$route['blog_details/(.*)'] = 'Home/blogs_list/$1';
$route['contact-us'] = 'Home_contact/index';
$route['payment-success'] = 'Home/paymentsuccess';
$route['policy/(.*)'] = 'Home/Policy/$1';
$route['product/(.*)'] = 'Home_product/index/$1';








