<!-- Credit alemohamad/laravel-requirements-check -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>WM Lab Laravel Prerequisite Check</title>
<style>
*{font-family:verdana; font-size:14px;}
h1{border-bottom:1px solid black; line-height: 20px;}
h4{border-bottom:1px solid black; line-height: 20px;}
.success{font-weight:bold; color:green;}
.error{font-weight:bold; color:red;}
.warning{font-weight:bold; color:orange;}
</style>
</head>
<body>
<?php

function is_cli() {
  return !isset($_SERVER['HTTP_HOST']);
}

function my_version_compare($ver1, $ver2, $operator = null)
{
    $p = '#(\.0+)+($|-)#';
    $ver1 = preg_replace($p, '', $ver1);
    $ver2 = preg_replace($p, '', $ver2);
    return isset($operator) ? 
        version_compare($ver1, $ver2, $operator) : 
        version_compare($ver1, $ver2);
}

function check($boolean, $message, $help = '', $fatal = false) {
  echo $boolean ? "  <span class='success'>OK</span>        " : sprintf("[[%s]] ", $fatal ? ' <span class="error">ERROR</span> ' : '<span class="warning">WARNING</span>');
  echo sprintf("$message%s\n", $boolean ? '' : ': <span class="error">FAILED</span>');
  if (!$boolean) {
    echo "            $help\n";
    if ($fatal) {
      die("\nYou must fix this problem before resuming the check.\n");
    }
  }
}


function get_ini_path() {
  if ($path = get_cfg_var('cfg_file_path')) {
    return $path;
  }
  return 'WARNING: not using a php.ini file';
}
if (!is_cli()) {
  echo '<pre>';
}
$error = 0;
echo "<h1>WM Lab Prerequisite Check</h1>";
if(dirname($_SERVER['REQUEST_URI']) != '/' && str_replace('\\', '/', dirname($_SERVER['REQUEST_URI'])) != '/')
{
  $error = 1;
  echo "<p class='error'>Error: You are trying to install this application in a subfolder '".dirname($_SERVER['REQUEST_URI'])."'.
We suggest you to install it in main domain or sub domain(live server) or create a virtual host(local server).</p>";
}
else
echo "<p class='success'>OK: Installation directory ".$_SERVER['SERVER_NAME'];
// echo "<h4>PHP settings</h4>";
// echo sprintf("  max_execution_time:  %s\n", ini_get('max_execution_time'));
// echo sprintf("  upload_max_filesize: %s\n", ini_get('upload_max_filesize'));
// echo sprintf("  post_max_size:       %s\n\n", ini_get('post_max_size'));
if (is_cli()) {
  echo "<p class='warning'>WARNING</p>";
  echo "<p>The PHP CLI can use a different php.ini file</p>";
  echo "<p>than the one used with your web server.</p>";
}
echo "<h4>Mandatory requirements (very important)</h4>";
$server = $_SERVER['SERVER_SOFTWARE'];
$server_is_ok = ( (stripos($server, 'Apache') === 0) || (stripos($server, 'nginx') === 0) );
check($server_is_ok, sprintf('Web server is suitable (%s)', $server), 'You should change the server to Apache or Nginx', true);
check(my_version_compare(phpversion(), '5.5.9', '>='), sprintf('PHP version is at least 5.5.9 (%s)', 'Current Version is '. phpversion()), 'Current version is '.phpversion(), true);
check(extension_loaded('fileinfo'), 'Fileinfo PHP extension loaded', 'Install and enable Fileinfo extension', true);
check(extension_loaded('mcrypt'), 'Mcrypt PHP extension loaded', 'Install and enable Mcrypt extension', true);
check(extension_loaded('openssl'), 'OpenSSL PHP extension loaded', 'Install and enable Mcrypt extension', true);
check(extension_loaded('tokenizer'), 'Tokenizer PHP extension loaded', 'Install and enable Mcrypt extension', true);
check(extension_loaded('mbstring'), 'Mbstring PHP extension loaded', 'Install and enable Mcrypt extension', true);
check(extension_loaded('zip'), 'Zip archive PHP extension loaded', 'Install and enable Mcrypt extension', true);
check(class_exists('PDO'), 'PDO is installed', 'Install PDO (mandatory for Eloquent)', true);
if (class_exists('PDO')) {
  $drivers = PDO::getAvailableDrivers();
  check(count($drivers), 'PDO has some drivers installed: '.implode(', ', $drivers), 'Install some PDO drivers (mandatory for Eloquent)');
}
// if (function_exists('apache_get_modules')) {
//   $modules = apache_get_modules();
//   $mod_rewrite = in_array('mod_rewrite', $modules) ? true : false;
// } else {
//   $mod_rewrite =  getenv('HTTP_MOD_REWRITE')=='On' ? true : false ;
// }
// check($mod_rewrite, 'Mod Rewrite is enabled', 'Enable Mod Rewrite Module', true);

if (!is_cli()) {
  echo '</pre>';
}
?>
<?php if($error != 1) { ?>
<p class="success">Great!! You are ready to install WM Lab application!!</p>
<?php } else { ?>
<p class="error">Sorry, Please fix the errors shown in red color before installation of the application!!</p>
<?php } ?>
</body>
</html>