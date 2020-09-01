<?php


  /**
  * Get all gmaps
  *
  * @param array $data Options for the function.
  * @return array json object with the gmaps id -> name
  */
  function achtvier_gmap_getall_masonry_galleries( ) {
    $query_args = array(
    'post_type' => 'bildergalerie',
   );
    $query = new WP_Query($query_args);
    $gmaps = $query->posts;


    if ( empty( $gmaps ) ) {
      return null;
    }
      return $gmaps;
    }



  add_action( 'rest_api_init', function () {
  register_rest_route( 'achtvier', '/masonry-galleries/all', array(
    'methods' => 'GET',
    'callback' => 'achtvier_gmap_getall_masonry_galleries',
   ) );
  } );
?>
