<?php
/**
 * @author  CurlWare-theme
 * @since   1.0.0
 * @version 1.0.0 
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<!--Preloader start here-->
<?php

get_template_part( 'inc/preloader' ); 

?>
<!--Preloader area end here-->


<div id="page" class="spria-heary-style hfeed spria_sticky">
	<header id="curlware-header" class="single-header">
		<div class="sticky-wrapper" style="height: auto;">
			<div class="sc-header-content sc-menu-sticky stuck">
				<?php
	do_action( 'socoders_elements_header' ); ?>
	</div>
</div>
</header>
<?php 
$layout_settings = get_post_meta(get_the_ID(), 'curlware_layout_settings', true);

if(isset($layout_settings['curlware_breadcrumb'])) {
	$spria_show_breadcrumb = $layout_settings['curlware_breadcrumb'];
	if ( 'on' == $spria_show_breadcrumb ) :
	spria_breadcrumb();
	endif;
}
?>
