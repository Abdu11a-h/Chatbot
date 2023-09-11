<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//echo '<pre>';print_r($_SERVER); exit;

defined('SCRIPT_VERSION') OR define('SCRIPT_VERSION', '?v=1.0.0.1');
defined('SITE_TITLE') OR define('SITE_TITLE', 'Gasses Observation System');

defined('SUPPORT_SITE') OR define('SUPPORT_SITE', 'Oxford Saudia');
defined('SUPPORT_EMAIL') OR define('SUPPORT_EMAIL', '');

defined('SMTP') OR define('SMTP', 'smtp.gmail.com');
defined('SMTP_USER') OR define('SMTP_USER', '');
defined('SMTP_PASSWORD') OR define('SMTP_PASSWORD', '');
defined('SMTP_PORT') OR define('SMTP_PORT', '');

defined('INFO_EMAIL') OR define('INFO_EMAIL', '');

defined('CONTACT_NO') OR define('CONTACT_NO', '');
defined('CONTACT_NO_DISPLAY') OR define('CONTACT_NO_DISPLAY', '');

defined('WHATSAPP') OR define('WHATSAPP', '');
defined('WHATSAPP_NO_DISPLAY') OR define('WHATSAPP_NO_DISPLAY', '');

if (ENVIRONMENT == 'development') {
    defined('ABSOLUTE_PATH') OR define('ABSOLUTE_PATH', dirname(__FILE__) . '\..\..\\');
} else {
    defined('ABSOLUTE_PATH') OR define('ABSOLUTE_PATH', dirname(__FILE__) . '/../../');
}

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://" . $_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

defined('SITEURL') OR define('SITEURL', $base_url);

defined('PER_PAGE') OR define('PER_PAGE', '20');

//The URL for the Website parent Directory

defined('ADMIN') OR define('ADMIN', SITEURL . 'Admin/');
defined('ADMIN_LOGIN') OR define('ADMIN_LOGIN', ADMIN . 'login/');
defined('ADMIN_DASHBOARD') OR define('ADMIN_DASHBOARD', ADMIN . 'dashboard/');
defined('ADMINFUNCTIONS') OR define('ADMINFUNCTIONS', SITEURL . 'AdminFunctions/');


defined('ASSETS') OR define('ASSETS', SITEURL . 'assets/');
defined('ASANTAXASSETS') OR define('ASANTAXASSETS', SITEURL . 'AsanTaxAssets/');
defined('ADMIN_ASSETS') OR define('ADMIN_ASSETS', SITEURL . 'admin_assets/');
defined('FRONT_ASSETS') OR define('FRONT_ASSETS', SITEURL . 'front_assets/');

defined('PORTALIMAGES') OR define('PORTALIMAGES', SITEURL . 'assets/portalimages/');
defined('VENDOR') OR define('VENDOR', ASSETS . 'vendors/');
defined('SRC') OR define('SRC', ASSETS . 'src/');
defined('DOCS') OR define('DOCS', ASSETS . 'docs/');
defined('BUILD') OR define('BUILD', ASSETS . 'build/');
defined('PRODUCTION') OR define('PRODUCTION', ASSETS . 'production/');
defined('INCLUDES') OR define('INCLUDES', SITEURL . 'application/views/Includes/');


