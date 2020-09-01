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
    array("id" => "test1",
"title" => "Test 1",
"post_type" => "beremed",
"args" => array("desc" => "test test test", "field" => "textfield"),
),array("id" => "testbild2",
"title" => "Testbild 2",
"post_type" => "beremed",
"args" => array("desc" => "test test tes 2", "field" => "mediabox"),
),


);
new DynamicMetaBoxes( $metaboxes );

add_action('save_post', 'beremed_save_step');

function beremed_save_step() {
    global $post;
    update_post_meta($post->ID, "test1", $_POST["test1"]);
update_post_meta($post->ID, "testbild2", $_POST["testbild2"]);
   }


?>
