<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "nhbomqlz_bommartdb" );

/** MySQL database username */
define( 'DB_USER', "nhbomqlz_bommart" );

/** MySQL database password */
define( 'DB_PASSWORD', "Bommart@123" );

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '#hzi55zBd]sQ?Hclf/9,B,P_{K-61Zqb}S}l*Q&{2S?pr2Cw04NZM4`x3JmJtpYi' );
define( 'SECURE_AUTH_KEY',   '0%G!UQs -Fxm`rKK5W5aLKTKieM*V]K@T@/iPfMoO6Kj~mKT4]h,3R.nQ-s0omcr' );
define( 'LOGGED_IN_KEY',     'FpU1hF27Z94I4qEXjE<p6=6V1I>cn`p/Xa_VCnc-_4/#<;8W%1+=Nx:gmU5v=x$F' );
define( 'NONCE_KEY',         'Yr:AwNAe$aNB{bB.@g/]ciyX)L[zHeSxyFWwFm!e BBU1`H}PN3:I3Hb~AUNBIaD' );
define( 'AUTH_SALT',         '!,h!lBwKv9ML%m,+m%`yuoSsz}qTgsNC{tRP|mwL+2i=q_87|-7P=_3fAp9hy.(k' );
define( 'SECURE_AUTH_SALT',  'y{O/Bzc/yI=_]}(]H!mUWu`I:JS]E#.(&f2jW8dSA( W&@(Jn%-FC6;1HrZE+LAi' );
define( 'LOGGED_IN_SALT',    'pdDfFG@CY1G1=4#>`=Xhm0Hrj]r]),>}gBX9gCI[9~^wg6x#d;:d.zDpu{`D)~NK' );
define( 'NONCE_SALT',        '7HXl]]54oa,7-zd,=Q_@+Jy1eFTwX54ZBl0!z*,;JpR&v=Z&q&BIkw`EM{OhKkj5' );
define( 'WP_CACHE_KEY_SALT', 'tR4x7t.2o9mlKYo{vLu#BodcjuFLc9$8!1zmL:hd9b99MQ}&3_S@>r=*7<n;aH,O' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


define( 'WP_DEBUG', false );


define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


/**  Giới hạn dung lượng upload file */
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

/** Bật debug có kiểm soát - Ghi log lỗi vào file wp-content/debug.log thay vì hiện lên giao diện người dùng – rất hữu ích khi phát triển hoặc fix bug.*/
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/** Force HTTPS cho toàn site - Ép trang admin và truy cập sử dụng SSL (HTTPS), tránh lỗi redirect hoặc cảnh báo bảo mật. */
define( 'FORCE_SSL_ADMIN', true );
if ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

/** Tắt sửa file qua wp-admin - Ngăn người khác chỉnh sửa theme/plugin qua trình soạn thảo admin (tăng bảo mật).*/
define( 'DISALLOW_FILE_EDIT', true );

/**Giới hạn sửa đổi bản nháp (revision) – tiết kiệm database
Chỉ lưu tối đa 5 bản nháp cũ cho mỗi bài viết.*/
define( 'WP_POST_REVISIONS', 5 );

/**Tăng bộ nhớ PHP cho WordPress - Rất cần thiết nếu bạn dùng page builder (Elementor, WPBakery...), WooCommerce, hoặc theme nặng.*/
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

// Optional (nếu cần fix URL)
define( 'WP_HOME', 'https://bommart.vn' );
define( 'WP_SITEURL', 'https://bommart.vn');