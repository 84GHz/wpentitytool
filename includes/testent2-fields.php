<?php 
/*
* Generate custom php_fields
*
*/
if (!(class_exists(DynamicMetaBoxes))) {
    require_once __DIR__ . '/includes/dynamicmetaboxes.php';
}

# ADD META BOXES - Fields in Worpress
$metaboxes = array(
    array("id" => "feld1",
"title" => "Feld1",
"post_type" => "testent2",
"args" => array("desc" => "Testfeld 1", "field" => "checkbox"),
),array("id" => "bildchen1",
"title" => "Bildchen1",
"post_type" => "testent2",
"args" => array("desc" => "Ein Bild", "field" => "mediabox"),
),


);
new DynamicMetaBoxes( $metaboxes );

add_action('save_post', 'testent2_save_step');

function testent2_save_step() {
    global $post;
    update_post_meta($post->ID, "feld1", $_POST["feld1"]);
update_post_meta($post->ID, "bildchen1", $_POST["bildchen1"]);
   }


?>
