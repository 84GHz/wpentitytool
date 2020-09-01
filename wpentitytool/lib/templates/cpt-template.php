<?php print ("<?php \n"); ?>
/**
*
* Registration unseres Custom Post Types "<?php print $name_singular ?>"
*
*/
function av_<?php print $name_machine ?>_type() {
$labels = array(
'name' => '<?php print $name_singular ?>',
'singular_name' => '<?php print $name_singular ?>',
'menu_name' => '<?php print $name_singular ?>',
'parent_item_colon' => '',
'all_items' => 'Alle <?php print $name_singular ?> Einträge',
'view_item' => 'Eintrag <?php print $name_singular ?> ansehen',
'add_new_item' => '<?php print $name_singular ?> hinzufügen',
'add_new' => 'Hinzufügen',
'edit_item' => '<?php print $name_singular ?> bearbeiten',
'update_item' => '<?php print $name_singular ?> Update ',
'search_items' => '',
'not_found' => '',
'not_found_in_trash' => '',
);
$rewrite = array(
'slug' => '<?php print $name_machine ?>',
'with_front' => true,
'pages' => true,
'feeds' => true,
);
$args = array(
'labels' => $labels,
'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'trackbacks', ),
'taxonomies' => array( 'category', 'post_tag' ),
'hierarchical' => false,
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'show_in_nav_menus' => true,
'show_in_admin_bar' => true,
'menu_position' => <?php print $menu_position ?>,
'can_export' => false,
'has_archive' => true,
'exclude_from_search' => false,
'publicly_queryable' => true,
'rewrite' => $rewrite,
'capability_type' => 'page',
);
register_post_type( '<?php print $name_machine ?>', $args );
}
// Hook into the 'init' action
add_action( 'init', 'av_<?php print $name_machine ?>_type', 0 );


function <?php print $name_machine ?>_load_admin_scripts( $hook ) {
		global $typenow;
		if( $typenow == '<?php print $name_machine ?>' ) {
			wp_enqueue_media();

            // Registers and enqueues the required javascript.
            wp_register_script('meta-box-image', plugins_url('/adminassets/mediaboxadmin.js', __FILE__), array('jquery'), '1.0', true);

			wp_localize_script( 'meta-box-image', 'meta_image',
				array(
					'title' => __( 'Choose or Upload Media', 'events' ),
					'button' => __( 'Use this media', 'events' ),
				)
			);
			wp_enqueue_script( 'meta-box-image' );

		}
	}
    add_action( 'admin_enqueue_scripts', '<?php print $name_machine ?>_load_admin_scripts', 10, 1 );


<?php print ('?>'); ?>

