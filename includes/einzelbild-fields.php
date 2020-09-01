<?php 
/*
* Generate custom php_fields
*
*/
if (!(class_exists("DynamicMetaBoxes"))) {
    require_once __DIR__ . '/dynamicmetaboxes.php';
}

# ADD META BOXES - Fields in Worpress
$metaboxes = array(
    array("id" => "gbild",
"title" => "Bild",
"post_type" => "einzelbild",
"args" => array("desc" => "Bild", "field" => "mediabox"),
),
array(
    'id' => 'galleryref',
    'title' => 'Galerie',
    'post_type' => 'einzelbild',
    'args' => array(
        'desc' => '',
        'field' => 'otmreference',
        'reference' => 'bildergalerie'
    ),
),


);
new DynamicMetaBoxes( $metaboxes );

add_action('save_post', 'einzelbild_save_step');
function einzelbild_save_step() {
    global $post;
    update_post_meta($post->ID, 'galleryref', $_POST['galleryref']);

    update_post_meta($post->ID, "gbild", $_POST["gbild"]);
   }


?>
