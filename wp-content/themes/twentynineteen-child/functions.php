<?php

if ( ! function_exists( 'mn_twentynineteen_child_enqueue_styles' ) ) {
	/**
	 * Enqueue styles
	 */
	function mn_twentynineteen_child_enqueue_styles() {
		/**
		 * The `get_template_directory_uri()` grab the parent theme full path uri.
		 * The `get_stylesheet_directory_uri()` grab the full URI of our child theme.
		 */
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'child-style', get_stylesheet_uri() . '/style.css', array( 'parent-style' ) );
	}
}

add_action( 'wp_enqueue_scripts', 'mn_twentynineteen_child_enqueue_styles' );

if ( ! function_exists( 'mn_add_business_to_query' ) ) {
	/**
	 * Add `Business` post types to wp query
	 *
	 * @param object $query wp query object.
	 * @return void
	 */
	function mn_add_business_to_query( $query ) {
		if ( $query->is_home() && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'post', 'business' ) );
		}
	}
}

add_action( 'pre_get_posts', 'mn_add_business_to_query' );


if ( ! function_exists( 'mn_show_events' ) ) {
	/**
	 * Query the events
	 *
	 * @return void
	 */
	function mn_show_events() {
		$args = array(
			'post_type'      => 'event',
			'posts_per_page' => 3,
		);

		$events = new \WP_Query( $args );

		if ( $events->have_posts() ) {
			echo '<ul class="event-list">';

			$format = '<li class="event"><a href="%1$s", title="%2$s">%2$s</a>: %3$s<li>';

			while ($events->have_posts() ) {
				$events->the_post();
				printf( $format, get_permalink(), get_the_title(), apply_filters( 'the_content', get_the_content() ) );
			}

			echo '</ul>';
		}
	}

	wp_reset_postdata();
}
