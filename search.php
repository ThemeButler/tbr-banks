<?php

beans_add_smart_action( 'beans_before_load_document', 'banks_search_setup_document' );

function banks_search_setup_document() {

    // Post.
    beans_add_attribute( 'beans_search_title', 'class', 'uk-margin-bottom-remove' );
    beans_add_attribute( 'beans_content', 'class', 'uk-article' );
    beans_remove_attribute( 'beans_post', 'class', 'uk-article' );
    beans_modify_markup( 'beans_post_title', 'h2' );
    beans_add_attribute( 'beans_post_title', 'class', 'uk-h2' );


    beans_add_attribute( 'beans_post', 'class', 'uk-grid-margin' );
    // Post image.
    beans_remove_action( 'beans_post_image' );

    // Post meta.
    beans_remove_action( 'beans_post_meta' );
    beans_remove_action( 'beans_post_meta_tags' );
    beans_remove_action( 'beans_post_meta_categories' );

    // Remove article search.
    beans_remove_output( 'beans_no_post_search_form' );

}


beans_add_smart_action( 'beans_search_title_after_markup', 'banks_search_field' );

function banks_search_field( $content ) {

	echo beans_open_markup( 'banks_search_content', 'div', array( 'class' => 'uk-grid-margin' ) );

    	get_search_form();

   	echo beans_close_markup( 'banks_search_content', 'div' );

}


beans_add_smart_action( 'the_content', 'banks_search_content' );

function banks_search_content( $content ) {

    $output = beans_open_markup( 'banks_search_content', 'p' );

    	$output .= beans_output( 'banks_search_post_content', substr( strip_tags( $content ), 0, 150 ) . ' ...' );

   	$output .= beans_close_markup( 'banks_search_content', 'p' );

   	return $output;

}


// Load beans document.
beans_load_document();