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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mampwp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'T#K.ti/2qJRmNwqc.?bjG~B69 .*M+>L( UF/?i$5^aNiPCk_*?^v&oymrtz10z]' );
define( 'SECURE_AUTH_KEY',  '%<OT9l%JyTOnr#tD9M)Fx8[@2r|/9c6j>Qaf<]M,r;?C]z@Dy$tUvz5+{F9=@b|b' );
define( 'LOGGED_IN_KEY',    '~&ZXXZ?`q;QILbpQtf Q1Hziq6i;y8I5s3x5Tm[nOJ!oT/F.R;vABm$sQuv4+(82' );
define( 'NONCE_KEY',        '})#0T.=}^F(yxZce<e)G:^i5U$&>1XNvTy(UO3CG[Wt#C855[`Z,J_a(*uaYpaj>' );
define( 'AUTH_SALT',        '6VBDCr6GJlI!tyX.Q;B;vpcX}8b8ivg`93&jd&V,[h0z,e;4-yJ|(9c^& pE3JQ}' );
define( 'SECURE_AUTH_SALT', ']+osC]&QvHRsNrD#$]q-:U4%@UZ?!%:yh&Fw=(J]Zkm>Ar3x<gL;qewH%_bRNT<<' );
define( 'LOGGED_IN_SALT',   'Y4DwVH(Sv_)!3UE>oq%Vfr}NHkM</z5G6Au>fJzkX$0U#Tm9<ua4@/[@x4d)lw-T' );
define( 'NONCE_SALT',       ' {d$3,bP:uJ+ADz:TnJ:2;f&~v6sjI<W%zW0:[KZ]jh=hwpfA.%kT-9z&f@LD<Bt' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp2_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
