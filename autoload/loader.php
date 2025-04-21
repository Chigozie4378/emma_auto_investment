<?php
$uri = $_SERVER['REQUEST_URI'];
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$session_set = false;

// Detect role from URI or referer
foreach (['director', 'manager', 'admin', 'staff'] as $role) {
    if (strpos($uri, $role) !== false || strpos($referer, $role) !== false) {
        session_name($role . '_sess');
        $session_set = true;
        break;
    }
}

// Handle root or default index fallback (e.g., / or /index.php)
$path = trim(parse_url($uri, PHP_URL_PATH), '/');
if (!$session_set && ($path === 'emma_auto_investment' || $path === 'emma_auto_investment/index.php' || $path === '')) {
    session_name('staff_sess');
    $session_set = true;
}

if (!$session_set) {
    die("Invalid session context: no matching role found in URI or referer.");
}

session_start();


error_reporting(E_ERROR);

// Define base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script = dirname($_SERVER['SCRIPT_NAME']);
$project = explode('/', trim($script, '/'))[0];
define('BASE_URL', $protocol . $host . '/' . $project . '/');

// Autoloading
function myAutoload($name)
{
    $paths = [
        "./classes/$name.php",
        "./classes/Controllers/$name.php",
        "../classes/$name.php",
        "../classes/Controllers/$name.php",
        "../../classes/$name.php",
        "../../classes/Controllers/$name.php",
        "../../../classes/$name.php",
        "../../../classes/Controllers/$name.php",
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
}
spl_autoload_register('myAutoload');
