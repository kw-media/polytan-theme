<?php
/**
 * Pagination layout.
 *
 * @package polytan
 */

if ( ! function_exists ( 'polytan_pagination' ) ) {

    function polytan_pagination($args = [], $class = 'pagination') {

        if ($GLOBALS['wp_query']->max_num_pages <= 1) return;

        $args = wp_parse_args( $args, [
            'mid_size'           => 2,
            'prev_next'          => true,
            'prev_text'          => __('&laquo;', 'polytan'),
            'next_text'          => __('&raquo;', 'polytan'),
            'screen_reader_text' => __('Posts navigation', 'polytan'),
            'type'               => 'array',
            'current'            => max( 1, get_query_var('paged') ),
        ]);

        $links = paginate_links($args);

        ?>

        <nav aria-label="<?php echo $args['screen_reader_text']; ?>">

            <ul class="pagination">

                <?php

                    foreach ( $links as $key => $link ) { ?>

                        <li class="page-item <?php echo strpos( $link, 'current' ) ? 'active' : '' ?>">

                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>

                        </li>

                <?php } ?>

            </ul>

        </nav>

        <?php
    }
}

?>
