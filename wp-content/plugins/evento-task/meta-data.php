<?php

class Evento_Meta{

    private static $_instance = null;
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }


    public function __construct() {
        // Add Plugin actions
        add_action( 'init', [ $this, 'events_custom_post_type' ] );
        add_action( 'save_post', [ $this,'save_events_meta_box_data' ] );
    }


    public function events_custom_post_type(){
        $labels = array(
            'name' => esc_html__('Events',  'evento-task'),
            'singular_name' => esc_html__('Event',  'evento-task'),
            'menu_name' => esc_html__('Events', 'evento-task'),
            'parent_item_colon' => esc_html__('Parent Events:', 'evento-task'),
            'all_items' => esc_html__('All Events', 'evento-task'),
            'view_item' => esc_html__('View Event', 'evento-task'),
            'add_new_item' => esc_html__('Add New Event', 'evento-task'),
            'add_new' => esc_html__('New Event', 'evento-task'),
            'edit_item' => esc_html__('Edit Event', 'evento-task'),
            'update_item' => esc_html__('Update Event', 'evento-task'),
            'search_items' => esc_html__('Search Events', 'evento-task'),
            'not_found' => esc_html__('No Events found', 'evento-task'),
            'not_found_in_trash' => esc_html__('No Events found in Trash', 'evento-task'),
        );
        $args = array(
            'label' => esc_html__('Events', 'evento-task'),
            'description' => esc_html__('Events', 'evento-task'),
            'labels' => $labels,
            'supports' => array( 'title', 'editor', 'thumbnail'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-calendar-alt',
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
            'register_meta_box_cb' => [ $this,'events_meta_box']
        );
        register_post_type('evento-task', $args);
    }

    public function events_meta_box() {

        add_meta_box(
            'events_meta',
            __( 'Events Date ', 'evento-task' ),
            [ $this, 'events_meta_box_callback' ],
            'evento-task'
        );
    }
    public function events_meta_box_callback( $event ) {

        wp_nonce_field( 'event_nonce', 'event_nonce' );

        $start_value = get_post_meta( $event->ID, '_event_start_date', true );
        $end_value = get_post_meta( $event->ID, '_event_end_date', true );

        ?>
        <div class="event_form">
            <div class="input_box">
                <label for="event_start_date">start date</label>
                <input data-toggle="datepicker" type="text" id="event_start_date" name="event_start_date" value="<?php echo esc_attr( $start_value ) ; ?>"/>
            </div>
            <div class="input_box">
                <label for="event_end_date">End date</label>
                <input data-toggle="datepicker" type="text" id="event_end_date" name="event_end_date" value="<?php echo esc_attr( $end_value ) ; ?>"/>
            </div>
        </div>
        <?php

    }

    /**
     * When the post is saved, saves our custom data.
     */
    function save_events_meta_box_data( $post_id ) {

        if ( ! isset( $_POST['event_nonce'] ) ) {return;}
        if ( ! wp_verify_nonce( $_POST['event_nonce'], 'event_nonce' ) ) {return;}
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {return;}

        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }

        }
        else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }


        if ( ! isset( $_POST['event_start_date'] ) ||  ! isset( $_POST['event_end_date'] )) {
            return;
        }

        // Sanitize user input.
        $start_date = sanitize_text_field( $_POST['event_start_date'] );
        $end_date = sanitize_text_field( $_POST['event_end_date'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_event_start_date', $start_date );
        update_post_meta( $post_id, '_event_end_date', $end_date );
    }

}
Evento_Meta::instance();
