<?php
/**
 * Functions for configuring demo importer.
 *
 * @author   dllcorpstheme1pack
 * @category Admin
 * @package  Importer/Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup demo importer packages.
 *
 * @param  array $packages
 * @return array
 */
function dllcorpstheme1_demo_importer_packages( $packages ) {
	$new_packages = array(
		'dllcorpstheme1-free' => array(
			'name'    => __( 'dllcorpstheme1', 'dllcorpstheme1' ),
			'preview' => 'http://demo.dllcorpstheme1pack.com/dllcorpstheme1/',
		),
	);

	return array_merge( $new_packages, $packages );
}
add_filter( 'dllcorpstheme1pack_demo_importer_packages', 'dllcorpstheme1_demo_importer_packages' );