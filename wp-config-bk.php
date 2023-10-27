<?php

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL
# Database Configuration
define( 'DB_NAME', 'wp_fiberlight' );
define( 'DB_USER', 'fiberlight' );
define( 'DB_PASSWORD', '1LDYvDsChsWgTpwfc3i7' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';
# Security Salts, Keys, Etc
define('AUTH_KEY',         'U=q>e/M36Z|h9]){[%@ZV7+,~#0^ln#rP$7iG:<kQJzoKut|$-:rY-z1EbK&vI=X');
define('SECURE_AUTH_KEY',  '+14F`PBf/?0AK0x-/=R<?EM{>``PB-Je+q25:-XThd63LhL-C%,i{.zs! }qg~~r');
define('LOGGED_IN_KEY',    'w/tK97Vhw$7,p>,D%yi.MC/vU>/bb2sv>ggDn||:9z9ZGwHgiTou6:U,4@FdH%z-');
define('NONCE_KEY',        'g<Vw;0p>=agR>83D$T3Q=r.+hR>!2jn|IiO&I+wp$;Mv)j.hx9iZyC|-O|q&1K^v');
define('AUTH_SALT',        '+ d,| ]2]EupX$-8+=y qJc{_UMRXp9^omU5|8vd0rRQnEphuT-`PC6ZK|y=_=-`');
define('SECURE_AUTH_SALT', '9?/OmY~K4qQnb|2jXW!_nmQlpL#7FKx6-ypSKo*#%6t+>+z+uK5r`shRx|DRmD({');
define('LOGGED_IN_SALT',   '/A?JbVx.g@QlS#[gV^V31W6;8}eoN7+V4{D-H|C?qam4T7oi;0E|DSma`}e03|x_');
define('NONCE_SALT',       'sab$W?m$0=FtcQG=(%WB<|0)&-21n+TO=7eI?dJ:3ggeOh|x|K+Ccd!+&#xZ(+1y');
# Localized Language Stuff
define( 'WP_CACHE', TRUE );
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'PWP_NAME', 'fiberlight' );
define( 'FS_METHOD', 'direct' );
define( 'FS_CHMOD_DIR', 0775 );
define( 'FS_CHMOD_FILE', 0664 );
define( 'PWP_ROOT_DIR', '/nas/wp' );
define( 'WPE_APIKEY', 'b91544ab59e1ac71a1e1c3be20474cb054b7cc31' );
define( 'WPE_CLUSTER_ID', '120363' );
define( 'WPE_CLUSTER_TYPE', 'pod' );
define( 'WPE_ISP', true );
define( 'WPE_BPOD', false );
define( 'WPE_RO_FILESYSTEM', false );
define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );
define( 'WPE_SFTP_PORT', 2222 );
define( 'WPE_LBMASTER_IP', '' );
define( 'WPE_CDN_DISABLE_ALLOWED', false );
define( 'DISALLOW_FILE_MODS', FALSE );
define( 'DISALLOW_FILE_EDIT', FALSE );
define( 'DISABLE_WP_CRON', false );
define( 'WPE_FORCE_SSL_LOGIN', true );
define( 'FORCE_SSL_LOGIN', true );
/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/
define( 'WPE_EXTERNAL_URL', false );
define( 'WP_POST_REVISIONS', FALSE );
define( 'WPE_WHITELABEL', 'wpengine' );
define( 'WP_TURN_OFF_ADMIN_BAR', false );
define( 'WPE_BETA_TESTER', false );
umask(0002);
$wpe_cdn_uris=array ( );
$wpe_no_cdn_uris=array ( );
$wpe_content_regexs=array ( );
$wpe_all_domains=array ( 0 => 'www.fiberlight.com', 1 => 'www.fiberlight.us', 2 => 'www.fiberlight.net', 3 => 'www.fiberlight.info', 4 => 'www.fiberlight.biz', 5 => 'fiberlight.us', 6 => 'fiberlight.net', 7 => 'fiberlight.info', 8 => 'fiberlight.biz', 9 => 'fiberlight.com', 10 => 'fiberlight.wpengine.com', 11 => 'fiberlight.wpenginepowered.com', );
$wpe_varnish_servers=array ( 0 => 'pod-120363', );
$wpe_special_ips=array ( 0 => '35.196.77.30', );
$wpe_ec_servers=array ( );
$wpe_netdna_domains=array ( 0 =>  array ( 'zone' => '46bpr041z4z5qpge43ag4kb5', 'match' => 'www.fiberlight.com', 'secure' => true, 'dns_check' => '0', ), );
$wpe_netdna_domains_secure=array ( 0 =>  array ( 'zone' => '46bpr041z4z5qpge43ag4kb5', 'match' => 'www.fiberlight.com', 'secure' => true, 'dns_check' => '0', ), );
$wpe_netdna_push_domains=array ( );
$wpe_domain_mappings=array ( );
$memcached_servers=array ( );

define( 'WPE_SFTP_ENDPOINT', '' );
define('WPLANG','');
# WP Engine ID
# WP Engine Settings
#define('WP_HOME','https://www.fiberlight.com');
#define('WP_SITEURL','https://www.fiberlight.com');
# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');




















