<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/*
/*
/*
IMPORTANT: DO NOT MODIFY ANY PORTION OF THIS FILE WITHOUT FIRST CONSULTING WITH drewadesigns.com
/*
/*
*/
define('DB_NAME', 'wp_bricksrus');
/** MySQL database username */
define('DB_USER', 'root');
define('WP_TEMP_DIR', 'C:\xampp\htdocs\bricksrus\wordpress-temp');

/** MySQL database password */
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
define('AUTH_KEY',         '@PVg{@CD|w3wWZT3?BkW;z@@su1|{7~R?eBIX%8^E+hGmSTl{FTuN9x:7N$Aj,:W');
define('SECURE_AUTH_KEY',  'lmg1cASQFW`dRN8}b(Xa];F%$d+nTTKSk-9Qm-NheWpQ)AUIm{JvU;-N(fnyPCk|');
define('LOGGED_IN_KEY',    '(@&p8x%W+ME-Td+*0spkxcW:[CBb_9Tuzo)z)9}aYk}S%#3B&9,-aNmKD)^b+CC{');
define('NONCE_KEY',        'Lo=Nka?S##CZYSPi~Kgy}Mye5PHVk2xTD+SqS8@q7@r{T-;Nbr_&-8,.)S^Qb=h!');
define('AUTH_SALT',        'CP8E*~?hR}14#uJ&aMG]]n== 6Do4qhd8kf3jsd]/lTldjlT45=2,5Z:&=n0yx|#');
define('SECURE_AUTH_SALT', '{{[-l_/nIYg-2R>{s:kW2Hk/Xz}PcDEK#2kL2xO-&@eG1p5T@EMjWj9?z{<MQm#o');
define('LOGGED_IN_SALT',   'd1}U:(q4yZjCfQg{L)-}jG]O4LtA@%C(c+*gJcUuWn#vPb^|XG6yHMD%gF7H 1WD');
define('NONCE_SALT',       'w,Y#Ku6V0Jt$jeNjyBoaMPRda<PX48na+q%:4thAZk|e0fDzPs3F|aAW+,pf>]w:');
 // Added by W3 Total Cache
$table_prefix  = 'wp_';
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY',false);
define( 'WP_MEMORY_LIMIT', '512M' );
define( 'WP_AUTO_UPDATE_CORE', true );
define('WP_ALLOW_REPAIR', true);
define('FS_METHOD', 'direct');
// FS_METHOD forces the filesystem method. It should only be “direct”, “ssh2”, “ftpext”, or “ftpsockets”. Generally, you should only change this if you are experiencing update problems. If you change it and it doesn’t help, change it back/remove it. Under most circumstances, setting it to ‘ftpsockets’ will work if the automatically chosen method does not.
// define('FS_METHOD', 'ftpsockets');
// define('FTP_HOST', '208.43.39.180');
// define('FTP_USER', 'bricksrus');
// define('FTP_PASS', 'NqJKX4nIywsAzSH');
// define('FTP_SSL', false);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');
?>