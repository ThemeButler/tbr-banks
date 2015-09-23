<?php

// Enqueue uikit assets.
beans_add_smart_action( 'beans_uikit_enqueue_scripts', 'banks_enqueue_uikit_assets', 5 );

function banks_enqueue_uikit_assets() {

	// Enqueue uikit overwrite theme folder.
	beans_uikit_enqueue_theme( 'banks', BEANS_THEME_PATH . 'assets/less/uikit' );

	// Add the theme style as a uikit fragment to have access to all the variables.
	beans_compiler_add_fragment( 'uikit', BEANS_THEME_PATH . 'assets/less/style.less', 'less' );

	// Add the theme js as a uikit fragment.
	beans_compiler_add_fragment( 'uikit', BEANS_THEME_PATH . 'assets/js/banks.js', 'js' );

	// Include the uikit components needed.
	beans_uikit_enqueue_components( array( 'contrast' ) );

}


// Add admin layout option.
add_filter( 'beans_layouts', 'banks_layouts' );

function banks_layouts( $layouts ) {

	$layouts['banks_c'] = BEANS_THEME_URL . 'assets/images/c.png';

	return $layouts;

}


// Set the default layout.
add_filter( 'beans_default_layout', 'banks_default_layout' );

function banks_default_layout() {

	return 'banks_c';

}


// Remove page post type comment support.
beans_add_smart_action( 'init', 'banks_post_type_support' );

function banks_post_type_support() {

	remove_post_type_support( 'page', 'comments' );

}


// Setup document fragements, markups and attributes.
add_action( 'beans_before_load_document', 'banks_setup_document' );

function banks_setup_document() {

  // Frontpage posts
  if ( is_home() )
    beans_remove_attribute( 'beans_post', 'class', 'uk-panel-box' );

  // Site Logo.
  beans_remove_attribute( 'beans_site_title_tag', 'class', 'uk-text-muted' );

  // Breadcrumb.
  beans_remove_action( 'beans_breadcrumb' );

	// Post meta.
	beans_add_attribute( 'beans_post_meta_date', 'class', 'uk-text-muted' );

	// Search form.
	beans_replace_attribute( 'beans_search_form', 'class', 'uk-form-icon uk-form-icon-flip', 'uk-display-inline-block' );
	beans_remove_markup( 'beans_search_form_input_icon' );

  // Add grid min width for Banks slim content
  if ( beans_get_layout() == 'banks_c' )
  	beans_add_attribute( 'beans_content', 'class', 'tm-centered-content' );

  // Only applies to singular and not pages
  if ( is_singular() && !is_page() ) {

    // Post title.
    beans_add_attribute( 'beans_post_title', 'class', 'uk-margin-small-bottom' );

    // Post navigation.
    beans_add_attribute( 'beans_post_navigation', 'class', 'uk-grid-margin uk-margin-bottom-remove' );

    // Post comments.
    beans_add_attribute( 'beans_comments', 'class', 'uk-margin-bottom-remove' );
    beans_add_attribute( 'beans_comment_form_wrap', 'class', 'uk-contrast' );
    beans_add_attribute( 'beans_comment_form_submit', 'class', 'uk-button-large' );
	  beans_add_attribute( 'beans_no_comment', 'class', 'tm-no-comments uk-text-center uk-text-large uk-block' );

  }

}


// Add primaray menu search field.
beans_add_smart_action( 'beans_primary_menu_append_markup', 'banks_primary_menu_search' );

function banks_primary_menu_search() {

  	echo beans_open_markup( 'banks_menu_primary_search', 'div', array(
  		'class' => 'tm-search uk-visible-large uk-navbar-content',
  		'style' => 'display: none;'
  	) );

		get_search_form();

	echo beans_close_markup( 'banks_menu_primary_search', 'div' );

	echo beans_open_markup( 'banks_menu_primary_search_toggle', 'div', array(
		'class' => 'tm-search-toggle uk-visible-large uk-navbar-content uk-display-inline-block uk-contrast'
	) );

		echo beans_open_markup( 'banks_menu_primary_search_icon', 'i', array( 'class' => 'uk-icon-search' ) );
		echo beans_close_markup( 'banks_menu_primary_search_icon', 'i' );

	echo beans_close_markup( 'banks_menu_primary_search_toggle', 'div' );

}


// Remove comment after note (filter).
add_action( 'comment_form_defaults', 'banks_comment_form_defaults' );

function banks_comment_form_defaults( $args ) {

    $args['comment_notes_after'] = '';

    return $args;

}


// Register bottom widget area.
beans_add_smart_action( 'widgets_init', 'banks_register_bottom_widget_area' );

function banks_register_bottom_widget_area() {

    beans_register_widget_area( array(
        'name' => 'Bottom',
        'id' => 'bottom',
        'description' => 'Widgets in this area will be shown in the bottom section as a grid.',
        'beans_type' => 'grid'
    ) );

}


// Add the bottom widget area.
beans_add_smart_action( 'beans_footer_before_markup', 'banks_bottom_widget_area' );

function banks_bottom_widget_area() {

	echo beans_open_markup( 'banks_bottom', 'section', array( 'class' => 'tm-bottom uk-block uk-padding-bottom-remove' ) );

		echo beans_open_markup( 'beans_fixed_wrap[_bottom]', 'div', 'class=uk-container uk-container-center' );

			echo beans_widget_area( 'bottom' );

		echo beans_close_markup( 'beans_fixed_wrap[_bottom]', 'div' );

	echo beans_close_markup( 'banks_bottom', 'section' );

}

// Add footer content
add_filter( 'beans_footer_credit_right_text_output', 'banks_footer' );

function banks_footer() { ?>

  <a href="http://www.themebutler.com/themes/banks/" target="_blank" title="Banks theme for WordPress">Banks</a> theme for <a href="http://wordpress.org" target="_blank">WordPress</a>.

<? }
