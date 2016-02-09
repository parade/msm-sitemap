<?php

if ( ! Metro_Sitemap::is_blog_public() ) {
	wp_die( 
		__( 'Sorry, this site is not public so sitemaps are not available.', 'msm-sitemap' ),
		__( 'Sitemap Not Available', 'msm-sitemap' ),
		array ( 'response' => 404 )
	);
}

/**
 * &amp; Bugfix
 * Correcting for the html encoded ampersand that comes along with
 * the fix for "build_xml entity reference" found in the msm-sitemap.php
 * file on line 609.
 */
foreach( $_GET as $key => $value ){
	if( strpos( $key, 'amp;' ) === 0 ){
		$new_key = str_replace( 'amp;', '', $key );
		$_GET[ $new_key ] = $value;
		unset( $_GET[ $key ] );
	}
}

$req_year = ( isset( $_GET['yyyy'] ) ) ? intval( $_GET['yyyy'] ) : false;
$req_month = ( isset( $_GET['mm'] ) ) ? intval( $_GET['mm'] ) : false;
$req_day = ( isset( $_GET['dd'] ) ) ? intval( $_GET['dd'] ) : false;

header( 'Content-type: application/xml; charset=UTF-8' );

$build_xml = Metro_Sitemap::build_xml( array( 'year' => $req_year, 'month' => $req_month, 'day' => $req_day ) );

if ( $build_xml === false ) {
	wp_die( __( 'Sorry, no sitemap available here.', 'msm-sitemap' ) );
} else {
	echo $build_xml;
}
?>
