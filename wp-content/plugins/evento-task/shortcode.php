<?php
function evento_list_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'posts_per_page' => '5',
        'order_by' => 'none',
    ), $atts );

    $query_args = array(
        'posts_per_page' => $a['posts_per_page'],
        'order' => $a['order_by'] ,
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

}
add_shortcode( 'evento_list', 'evento_list_shortcode' );
