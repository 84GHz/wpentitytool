<?php print ("<?php \n"); ?>
/*
* Generate custom php_fields
*
*/
if (!(class_exists(DynamicMetaBoxes))) {
    require_once __DIR__ . '/dynamicmetaboxes.php';
}

# ADD META BOXES - Fields in Worpress
$metaboxes = array(
    <?php
        $singlearray;
        foreach ($args as $value) {
            # code...
            $singlearray .= "array(";
            $singlearray .= '"id" => "' . $value['field_machine_name'] . '",' . "\n";
            $singlearray .= '"title" => "' . $value['field_label'] . '",' . "\n";
            $singlearray .= '"post_type" => "' . $value['post_type'] . '",' . "\n";
            $singlearray .= '"args" => array("desc" => "'. $value['field_description']  .'", "field" => "' . $value['field_type'] . '"),' . "\n";
            $singlearray .= '),';            

        }

        print $singlearray;
        ?>



);
new DynamicMetaBoxes( $metaboxes );

add_action('save_post', '<?php print $args[0]['post_type']?>_save_step');

function <?php print $args[0]['post_type']?>_save_step() {
    global $post;
    <?php
    foreach ($args as $value) {
        print 'update_post_meta($post->ID, "' . $value['field_machine_name'] . '", $_POST["' . $value['field_machine_name'] . '"]);' . "\n";
    }
    ?>
   }


<?php print ("?>\n"); ?>
