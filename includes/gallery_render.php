<?php
function render_av_masonry_gallery($attributes ) {
    
    $args = array(
        'numberitems' => $attributes['itemsToShow'],
        'order'       => $attributes['order'],
        'orderby'     => $attributes['orderBy'],
        'numbercols'  => $attributes['numberCols'],
        'post_type'=> 'einzelbild',
        'ordered'     => $attributes['ordered'],
        'meta_key'   => 'galleryref',
        'meta_value' => $attributes['selectedGalleryEntity'],

 );
  if ( isset( $attributes['categories'] ) ) {
    $args['category'] = $attributes['categories'];
 }
  $list_items_markup = '<div class="achtvier-masonry-wrapper" data-ordered="' . $attributes['ordered'] . '" data-gutterwidth="'. $attributes['gutterWidth'] .'">';
  $list_items_markup .= '<div class="avmasgutter"></div>';
  $gallery_items = get_posts($args);
  foreach ( $gallery_items as $item ) {
    $post_id = $item->ID;
    $title = get_the_title( $post_id );
    $content = get_the_content($item->ID);
    $metas = get_metadata('post',$post_id,'',true);   
    $list_items_markup .= '<div class="av-gallery-grid-item av-mas-col-l-'. $attributes['numberCols'] .' av-mas-col-s-'. $attributes['numberColsTablet'] .' av-mas-col-xs-'. $attributes['numberColsMobile'] .' ">';
    $list_items_markup .= '<img src="' . $metas['gbild'][0] . '">';
    $list_items_markup .= '<div class="av-masonry-title">' . $title . '</div>';
    $list_items_markup .= '<div class="av-masonry-description">' . $item->post_content .  '</div>';

    if ( ! $title ) {
      $title = __( '(Untitled)' );
     }

   $list_items_markup .= '</div>';
  }
  $list_items_markup .= '</div>';
  return $list_items_markup;
} 

function av_masonry_gallery_block_init() {
    $dir = dirname( __FILE__ );

    $index_js = '../blocks/av-masonry-gallery/index.js';
    wp_register_script(
            'av-masonry-gallery-block-editor',
            plugins_url( $index_js, __FILE__ ),
            array(
                    'wp-blocks',
                    'wp-i18n',
                    'wp-element',
  'wp-components',
  'wp-editor',
  'wp-data',
  'wp-api-fetch',
  'wp-date'
            ),
            filemtime( "$dir/$index_js" )
    );

    $editor_css = '../blocks/av-masonry-gallery/editor.css';
    wp_register_style(
            'av-masonry-gallery-block-editor',
            plugins_url( $editor_css, __FILE__ ),
            array(),
            filemtime( "$dir/$editor_css" )
    );

    $style_css = '../blocks/av-masonry-gallery/style.css';
    wp_register_style(
            'av-masonry-gallery-block',
            plugins_url( $style_css, __FILE__ ),
            array(),
            filemtime( "$dir/$style_css" )
    );
    register_block_type( 'achtvier-blocks/achtvier-masonry-gallery', array(
        'editor_script' => 'av-masonry-gallery-block-editor',
        'editor_style'  => 'av-masonry-gallery-block-editor',
        'style'         => 'av-masonry-gallery-block',
        'attributes'      => array(
'categories'      => array(
        'type' => 'string',
),
'className'       => array(
        'type' => 'string',
),
'itemsToShow'     => array(
        'type'    => 'number',
        'default' => 5,
),

'numberCols'     => array(
        'type'    => 'number',
        'default' => 4,
),
'numberColsTablet'     => array(
        'type'    => 'number',
        'default' => 4,
),
'numberColsMobile'     => array(
        'type'    => 'number',
        'default' => 4,
),
'gutterWidth'     => array(
        'type'    => 'number',
        'default' => 0,
),


'order'           => array(
        'type'    => 'string',
        'default' => 'desc',
),
'selectedGalleryEntity'           => array(
        'type'    => 'string',
        'default' => 'desc',
),
'ordered'           => array(
        'type'    => 'boolean',
        'default' => 'false',
),
'showFilters'           => array(
        'type'    => 'boolean',
        'default' => 'false',
),
'orderBy'         => array(
        'type'    => 'string',
        'default' => 'date',
),
),
'render_callback' => 'render_av_masonry_gallery',

) );


}


add_action( 'init', 'av_masonry_gallery_block_init' );


?>