<?php

# Include the database credentials
require_once(dirname(__FILE__).'/private.php');

# User signed in?
define('SIGNED_IN', false);#isset($_COOKIE['u']) && $_COOKIE['u'] == md5(SALT.substr($_COOKIE['u'], 32)).substr($_COOKIE['u'], 32) ? substr($_COOKIE['u'], 32) : 0);

# User account constraints
$min_username_len = 5;
$max_username_len = 25;
$min_password_len = 5;
$max_password_len = 25;

# Constants can't hold arrays, so define configurations that need arrays here
$cnf = array(
  'requires'=>array(
    'models/*'
  )
);

# Turn off dumb ass magic_quotes_gpc that is still enabled on the dinosaur server
if (get_magic_quotes_gpc()) {
  $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
  while (list($key, $val) = each($process)) {
    foreach ($val as $k => $v) {
      unset($process[$key][$k]);
      if (is_array($v)) {
        $process[$key][stripslashes($k)] = $v;
        $process[] = &$process[$key][stripslashes($k)];
      } else {
        $process[$key][stripslashes($k)] = stripslashes($v);
      }
    }
  }
  unset($process);
}
?>
