<?php
class events_List_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'evento_task_list', // Base ID
            esc_html__( 'Events - List ', 'evento-task'), // Name
            array('description' => esc_html__('Display a list of your Events.', 'evento-task'),) // Args
        );
    }

    function widget( $args, $instance ) {
        ob_start();

        $title                  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $posts_per_page         = absint( $instance['posts_per_page'] );
        $order_by                = sanitize_title( $instance['order_by'] );

        echo $args['before_widget'];

        if ( $title ) echo  $args['before_title'] . $title .  $args['after_title'];

        $query_args = array(
            'posts_per_page' => $posts_per_page,
            'order' => $order_by,
            'post_type' => 'evento-task',
            'post_status' => 'publish'
        );

        $wp_query = new WP_Query($query_args);

        if ($wp_query->have_posts()){
            ?>
            <ul class="evento-list">
                <?php while ($wp_query->have_posts()){ $wp_query->the_post(); ?>
                    <li>
                        <?php
                        $start_date = get_post_meta( get_the_ID(), '_event_start_date', TRUE );
                        $end_date = get_post_meta( get_the_ID(), '_event_end_date', TRUE );
                        if( has_post_thumbnail() ){
                            $thumbnail_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
                            echo '<a href="'.get_the_permalink().'" class="evento-thumb-link"><div class="evento-thumb" style="background: url('.esc_url($thumbnail_data[0]).')"></div></a>';
                        }
                        ?>
                        <h6 class="evento-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                        <div class="event-dates">
                            <span class="start-date">
                                <?php echo esc_html($start_date); ?>
                            </span>
                            -
                            <span class="end-date">
                                <?php  echo esc_html($end_date); ?>
                            </span>
                        </div>
                        <div class="evento-meta">
                            <span><?php echo get_the_date('M d, Y'); ?></span>
                            <span><?php esc_html_e('By ', 'evento-task'); echo get_the_author(); ?></span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }
        wp_reset_postdata();
        echo $args['after_widget'];
        $content = ob_get_clean();
        echo ''.$content;
    }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {$title = $instance['title'];}else{$title = __( 'Events List', 'evento-task' );};
        if ( isset( $instance[ 'posts_per_page' ] ) ) {$posts_per_page = $instance['posts_per_page'];}else{$posts_per_page =  '3' ;};
        if ( isset( $instance[ 'order_by' ] ) ) {$order_by = $instance['order_by'];}else{$order_by =  'none' ;};

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label  for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" > <?php _e( 'Number of posts to show:' ); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" min="1" step="1" type="number" value="<?php echo esc_attr( $posts_per_page ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php _e( 'Order by:' ); ?></label>
            <select  class="widefat" id="<?php echo $this->get_field_id( 'order_by' ); ?>" name="<?php echo $this->get_field_name( 'order_by' ); ?>">
                <option value='none' <?php selected( $instance['order_by'], 'none'); ?>   ><?php echo esc_html__( 'None', 'evento-task' ); ?></option>
                <option value="asc"  <?php selected( $instance['order_by'], 'asc'); ?> > <?php echo esc_html__( 'ASC', 'evento-task' ); ?></option>
                <option value="desc"    <?php selected( $instance['order_by'], 'desc'); ?>  ><?php echo esc_html__( 'DESC', 'evento-task' ); ?></option>
            </select>
        </p>
        <?php
    }
    function update($new_instance, $old_instance) {
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['posts_per_page'] = $new_instance['posts_per_page'];
        $instance['order_by'] = $new_instance['order_by'];
        return $instance;
    }
}
/* Class events_List_Widget */
function register_events_List_Widget() {
    register_widget('events_List_Widget');
}
add_action('widgets_init', 'register_events_List_Widget');