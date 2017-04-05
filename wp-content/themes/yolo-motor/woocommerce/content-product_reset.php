<?php
/**
 *	Template for displaying shop results bar/button
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$yolo_options = yolo_get_options();

$results_bar_class = '';
$results_bar_buttons = array();

// Filters
$filters_count = yolo_active_filters_count();
if ( $filters_count ) {
    $results_bar_class = ' has-filters';
    $results_bar_buttons['filters'] = array(
        'id'    => 'yolo-filters-reset',
        'title' => sprintf( esc_html__( 'Filters active %s(%s)%s', 'yolo-motor' ), '<span>', $filters_count, '</span>' )
    );
}

// Search
if ( ! empty( $_REQUEST['s'] ) ) { // Is search query set and not empty?
    $results_bar_class .= ' is-search';
    $results_bar_buttons['search_taxonomy'] = array(
        'id'    => 'yolo-shop-search-taxonomy-reset',
        'title' => sprintf( esc_html__( 'Search results for %s&ldquo;%s&rdquo;%s', 'yolo-motor' ), '<span>', esc_html( $_REQUEST['s'] ), '</span>' )
    );
}
// Tag
else if ( is_product_tag() ){
    $current_term = $GLOBALS['wp_query']->get_queried_object();
    $results_bar_class .= ' is-tag';
    $results_bar_buttons['search_taxonomy']['id'] = 'yolo-shop-search-taxonomy-reset';
    $results_bar_buttons['search_taxonomy']['title'] = sprintf( esc_html__( 'Products tagged: %s&ldquo;%s&rdquo;%s', 'yolo-motor' ), '<span>', esc_html( $current_term->name ), '</span>' );
}
// if(! empty( $_REQUEST['orderby'])){
//     $results_bar_buttons['search_taxonomy'] = array(
//         'id' => 'is-orderby',
//         'title'=> sprintf( esc_html__( 'Sortby results for %s&ldquo;%s&rdquo;%s', 'yolo-motor' ), '<span>', esc_html( $_REQUEST['orderby'] ), '</span>' )
//     );
// }

if ( ! empty( $results_bar_buttons ) ) :
?>

<div class="yolo-shop-results-bar <?php echo esc_attr( $results_bar_class ); ?>">
    <?php 
        $shop_url = esc_url( get_permalink( wc_get_page_id( 'shop' ) ) );
        foreach ( $results_bar_buttons as $button ) {
            printf( '<a href="%s" id="%s">%s</a>',
                $shop_url,
                $button['id'],
                $button['title']
            );
        }
    ?>
</div>

<?php endif; ?>
