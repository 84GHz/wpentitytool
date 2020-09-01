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
"post_type" => "testent",
"args" => array("desc" => "keine", "field" => "textfield"),
),array("id" => "feld2",
"title" => "Feld2",
"post_type" => "testent",
"args" => array("desc" => "Testfiel2", "field" => "mediabox"),
),


);
new DynamicMetaBoxes( $metaboxes );

add_action('save_post', 'testent_save_step');

function testent_save_step() {
    global $post;
    update_post_meta($post->ID, "feld1", $_POST["feld1"]);
update_post_meta($post->ID, "feld2", $_POST["feld2"]);
   }


?>
