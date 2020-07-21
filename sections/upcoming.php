<?php
$event_type = get_sub_field('event_type');
$today = date("Ymd");
$args = array(
    'post_type' => $event_type,
    'posts_per_page' => 3,
    'meta_key'   => 'dates_0_date',
    'orderby'    => 'meta_value_num',
    'order'      => 'ASC',
    'meta_query' => array(
        array(
            'key'     => 'dates_0_date',
            'value'   => $today,
            'compare' => '>=',
        )
    )
);
$loop = new WP_Query($args);
?>


<div class="black_box upcoming" style="display:none">
    <div class="container" style="text-align: center;">
        <h2><a href="<?php echo get_sub_field('link'); ?>">Prochainement</a></h2>
        <h6><a href="<?php echo get_sub_field('link'); ?>"><?php echo get_sub_field('link_text'); ?></a></h6>
    </div>
</div>



<div id="prochainement">
    <h3>Prochainement</h3>
</div>
<div id="upcoming_events">

    <div class="column_container">
        <?php $color_classes = ['grey_event', 'yellow_event', 'black_event']; ?>
        <?php $o = 0;
        while ($loop->have_posts()) : $loop->the_post(); ?>
            <div class="column upcoming_event_column <?php echo $color_classes[$o];
                                                        $o++ ?> ">
                <a href="<?php the_permalink(); ?>">
                    <div class="event_thumb" style=" background-image:url(<?php if (has_post_thumbnail()) {
                                                                                echo get_the_post_thumbnail_url();
                                                                            } else {
                                                                                echo get_template_directory_uri() . '/img/placeholder.jpg';
                                                                            } ?>); background-size:cover;"></div>
                    <div class="upcoming_description">
                        <h3><?php the_title(); ?></h3>
                        <br>
                        <div class="event_date">
                            <?php $id = get_the_ID(); ?>
                            <?php $dates = get_field('dates', $id, false); ?>

                            <?php if ($dates) : ?>
                                <?php echo other_nice_event_dates($dates); ?>
                            <?php endif; // end of if dates  
                            ?>



                        </div>
                    </div>
                </a>
            </div>

        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
    </div>
</div> <!--  END OF UPCOMING EVENTS -->