<?php
class DynamicMetaBoxes
{
    private $boxes;

    # Safe to start up
    public function __construct( $args )
    {
        $this->boxes = $args;
        add_action( 'plugins_loaded', array( $this, 'start_up' ) );
        add_action( 'post_edit_form_tag' , array( $this, 'post_edit_form_tag' )  );



    }
    public function post_edit_form_tag( ) {
        echo ' enctype="multipart/form-data"';
    }

    public function start_up()
    {
        add_action( 'add_meta_boxes', array( $this, 'add_mb' ) );
    }
    public function getMetaBoxes() {
        return $this->$boxes;
    }
    public function add_mb()
    {
        foreach( $this->boxes as $box )
            add_meta_box(
                $box['id'],
                $box['title'],
                array( $this, 'mb_callback' ),
                $box['post_type'],
                isset( $box['context'] ) ? $box['context'] : 'normal',
                isset( $box['priority'] ) ? $box['priority'] : 'default',
                $box['args']
            );
    }

    # Callback function, uses helper function to print each meta box
    public function mb_callback( $post, $box )
    {
        switch( $box['args']['field'] )
        {
            case 'textfield':
                $this->textfield( $box, $post->ID );
            break;
            case 'checkbox':
                $this->checkbox( $box, $post->ID );
            break;
            case 'datepicker':
                $this->datepicker( $box, $post->ID );
            break;
            case 'textarea':
                $this->textarea( $box, $post->ID );
            break;
            case 'image_field':
                $this->image_field( $box, $post->ID );
            break;
            case 'mediabox':
                $this->mediabox( $box, $post->ID );
            case 'otmreference':
                $this->otmreference( $box, $post->ID );
            break;
        }
    }

    private function textfield( $box, $post_id )
    {

        $post_meta = get_post_meta( $post_id, $box['id'], true );
        printf(
            '<label>%s: <input type="text" name="%s" value="%s" /></label> <small>%s</small><br/>',
            $box['title'],
            $box['id'],
            $post_meta,
            $box['args']['desc']
        );
    }
    private function textarea( $box, $post_id )
    {

        $post_meta = get_post_meta( $post_id, $box['id'], true );
        $value = get_post_meta( $post_id, $box['id'], true );
        if ( false === $value ) {
            $value = '';
        }
        wp_editor( htmlspecialchars_decode($value), 'vereins-info', $settings = array('textarea_name'=>$box['id']) );

    }


    protected function echo_ckeditor($custom_field_key, $post_id = 0) {
        //$custom_field_key = $this->get_a_custom_field_key_from_label( $custom_field_label );
        //d($custom_field_key);
        $value = get_post_meta( $post_id, 'tribe_events_tribe_ext_verein_details', true );
        if ( false === $value ) {
            $value = '';
        }
        wp_editor( htmlspecialchars_decode($value), 'vereins-tribe-info', $settings = array('textarea_name'=>$custom_field_key) );

    }

    private function checkbox( $box, $post_id )
    {
        $post_meta = get_post_meta( $post_id, $box['id'], true );
        printf(
            '<label>%s: </label><input type="checkbox" name="%s" %s /> <small>%s</small><br/>',
            $box['title'],
            $box['id'],
            checked( 'on', $post_meta, false ),
            $box['args']['desc']
        );
    }
    private function datepicker( $box, $post_id )
    {
        $post_meta = get_post_meta( $post_id, $box['id'], true );
        if ($post_meta == "") {
            printf(
                //'<label>%s: </label><input type="checkbox" name="%s" %s /> <small>%s</small><br/>',
                '<label>%s: </label><input type="text" class="metabox-datepicker" name="%s" value="%s"/> <small>%s</small><br/>',
                $box['title'],
                $box['id'],            
                gmdate("d.m.Y H:i", time()),
                $box['args']['desc']
            );
        }
        else {
            printf(
                //'<label>%s: </label><input type="checkbox" name="%s" %s /> <small>%s</small><br/>',
                '<label>%s: </label><input type="text" class="metabox-datepicker" name="%s" value="%s"/> <small>%s</small><br/>',
                $box['title'],
                $box['id'],            
                gmdate("d.m.Y H:i", intval($post_meta)),
                $box['args']['desc']
            );
        }

    }

    private function image_field( $box, $post_id )
    {
        $post_meta = get_post_meta( $post_id, $box['id'], true );
        wp_nonce_field(plugin_basename(__FILE__), 'wp_image_field_nonce');
        $html = '';
        $html .= '<label for="' . $box['id'] . '">';
        $html .= $box['title'] ;
        $html .= '</label>';
        $html .= '<input type="file" id="' . $box['id']. '" name="'. $box['id'] . '"  size="25">';
        $html .= '<p>' . $post_meta . '</p>';
        echo $html;
    }

    private function otmreference( $box, $post_id )
    {
        $post_meta = get_post_meta( $post_id, $box['id'], true );
        $query = new WP_Query(array(
            'post_type' =>  $box['args']['reference'],         
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));

        
        $html = '<label>' . $box['title'] . "</label>\n";
        $html .= '<select name="'  . $box['id'] . '" class = "flexselect">';
            while ($query->have_posts()) {
                $query->the_post();
                $current_id = get_the_ID();
                $selected = "";
                if ($current_id == $post_meta) {
                    $selected = "selected";
                }

                $html .= '<option value="' . $current_id . '" ' . $selected . '>'. get_the_title() .'</option>';
            }

        $html .= '</select>';    
        echo $html;    

        


    }


    	/**
	 * Render the metabox
	 */
	function mediabox($box, $post_id) {

		// Variables
        $saved = get_post_meta( $post_id, $box['id'] , true );
        $post_meta = get_post_meta( $post_id, $box['id'], true );
        wp_nonce_field(plugin_basename(__FILE__), 'wp_image_field_nonce');
        $html = '';
        $html .= '<label for="' . $box['id'] . '">';
        $html .= $box['title'] ;
        $html .= '</label>';
        $html .= '<input type="text" name="'. $box['id'] . '"  size="25">';
        $html .= '<button type="button" class="button" id="events_video_upload_btn" data-media-uploader-target="#' .$box[id] . '"> select media</button>';
        

        $html .= '<p>' . $post_meta . '</p>';
        echo $html;



		?>
        

		<?php

		// Security field


	}



  }
    ?>