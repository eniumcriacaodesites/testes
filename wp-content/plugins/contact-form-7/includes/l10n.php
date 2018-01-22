<?php

function wpcf7_l10n() {
	static $l10n = array();

	if ( ! empty( $l10n ) ) {
		return $l10n;
	}

	if ( ! is_admin() ) {
		return $l10n;
	}

	require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );

	$api = translations_api( 'plugins', array(
		'slug' => 'contact-form-7',
		'version' => WPCF7_VERSION,
	) );

	if ( is_wp_error( $api ) || empty( $api['translations'] ) ) {
		return $l10n;
	}

	foreach ( (array) $api['translations'] as $translation ) {
		if ( ! empty( $translation['language'] )
		&& ! empty( $translation['english_name'] ) ) {
			$l10n[$translation['language']] = $translation['english_name'];
		}
	}

	return $l10n;
}

function wpcf7_is_valid_locale( $locale ) {
	$pattern = '/^[a-z]{2,3}(?:_[a-zA-Z_]{2,})?$/';
	return (bool) preg_match( $pattern, $locale );
}

function wpcf7_is_rtl( $locale = '' ) {
	static $rtl_locales = array(
		'ar' => 'Arabic',
		'ary' => 'Moroccan Arabic',
		'azb' => 'South Azerbaijani',
		'fa_IR' => 'Persian',
		'haz' => 'Hazaragi',
		'he_IL' => 'Hebrew',
		'ps' => 'Pashto',
		'ug_CN' => 'Uighur',
	);

	if ( empty( $locale ) && function_exists( 'is_rtl' ) ) {
		return is_rtl();
	}

	if ( empty( $locale ) ) {
		$locale = get_locale();
	}

	return isset( $rtl_locales[$locale] );
}

function wpcf7_load_textdomain( $locale = null ) {
	global $l10n;

	$domain = 'contact-form-7';

	if ( get_locale() == $locale ) {
		$locale = null;
	}

	if ( empty( $locale ) ) {
		if ( is_textdomain_loaded( $domain ) ) {
			return true;
		} else {
			return load_plugin_textdomain( $domain, false, $domain . '/languages' );
		}
	} else {
		$mo_orig = $l10n[$domain];
		unload_textdomain( $domain );

		$mofile = $domain . '-' . $locale . '.mo';
		$path = WP_PLUGIN_DIR . '/' . $domain . '/languages';

		if ( $loaded = load_textdomain( $domain, $path . '/'. $mofile ) ) {
			return $loaded;
		} else {
			$mofile = WP_LANG_DIR . '/plugins/' . $mofile;
			return load_textdomain( $domain, $mofile );
		}

		$l10n[$domain] = $mo_orig;
	}

	return false;
}
