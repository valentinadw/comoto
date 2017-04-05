<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    26/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
if ( class_exists( 'WooCommerce' ) ) {
    // $yolo_options = yolo_get_options();
    // Disable Redirect Single Search Result
    add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );
    /*================================================
    1. SALE FLASH MODE
    ================================================== */
    if ( ! function_exists('yolo_woocommerce_sale_flash') ) {
        function yolo_woocommerce_sale_flash($sale_flash,$post,$product) {
            $yolo_options = yolo_get_options();
            $product_sale_flash_mode = isset($yolo_options['product_sale_flash_mode']) ? $yolo_options['product_sale_flash_mode'] : '' ;
            if ($product_sale_flash_mode == 'percent') {
                $sale_percent = 0;
                if ($product->is_on_sale() && $product->product_type != 'grouped') {
                    if ($product->product_type == 'variable') {
                        $available_variations =  $product->get_available_variations();
                        for ($i = 0; $i < count($available_variations); ++$i) {
                            $variation_id      = $available_variations[$i]['variation_id'];
                            $variable_product1 = new WC_Product_Variation( $variation_id );
                            $regular_price     = $variable_product1->get_regular_price();
                            $sales_price       = $variable_product1->get_sale_price();
                            $price             = $variable_product1->get_price();
                            if ( $sales_price != $regular_price && $sales_price == $price ) {
                                $percentage= round((( ( $regular_price - $sales_price ) / $regular_price ) * 100),1) ;
                                if ($percentage > $sale_percent) {
                                    $sale_percent = $percentage;
                                }
                            }
                        }
                    } else {
                        $sale_percent = round((( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100),1) ;
                    }
                }
                if ($sale_percent > 0) {
                    return '<span class="on-sale product-flash">' . $sale_percent . '%</span>' . '<span class="on-sale product-flash">' . esc_html__( 'Sale', 'yolo-motor' ) . '</span>';
                } else {
                    return "";
                }

            }
            return $sale_flash;
        }
        add_filter('woocommerce_sale_flash','yolo_woocommerce_sale_flash',10,3);
    }

    /*================================================
    2. FILTER HOOK
    ================================================== */
    remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);
    add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_product_title',15);

    /*================================================
    3. SHOW RATING EVENT IF PRODUCT HADN'T BEEN REVIEWED
    ================================================== */
    add_filter('woocommerce_product_get_rating_html', 'yolo_get_rating_html', 10, 2);

    function yolo_get_rating_html($rating_html, $rating) {
        $yolo_options = yolo_get_options();
        $rating_class = '';
        $rating_option = $yolo_options['product_show_rating']? true : $yolo_options['product_show_rating'];
        if( $rating_option == false ) {
            $rating_class = 'rating-invisible';
        }
        if ( $rating > 0 ) {
            $title = sprintf( esc_html__( 'Rated %s out of 5', 'yolo-motor' ), $rating );
        } else {
            $title = 'Not yet rated';
            $rating = 0;
        }

        $rating_html  = '<div class="star-rating ' . $rating_class . '" title="' . $title . '">';
        $rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_html__( 'out of 5', 'yolo-motor' ) . '</span>';
        $rating_html .= '</div>';

        return $rating_html;
    }

    /*================================================
    4. QUICK VIEW TEMPLATE
    ================================================== */
    if (!function_exists('yolo_woocomerce_template_loop_quick_view')) {
        function yolo_woocomerce_template_loop_quick_view() {
            wc_get_template( 'loop/quick-view.php' );
        }
        add_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_quick_view', 25 );
    }

    /*================================================
    5. WHISHLIST TEMPLATE
    ================================================== */
    if (!function_exists('yolo_woocomerce_template_loop_wishlist')) {
        function yolo_woocomerce_template_loop_wishlist() {
            wc_get_template( 'loop/wishlist.php' );
        }
        add_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_wishlist', 5 );
    }

    /*================================================
    6. COMPARE TEMPLATE
    ================================================== */
    if (!function_exists('yolo_woocomerce_template_loop_compare')) {
        function yolo_woocomerce_template_loop_compare() {
            wc_get_template( 'loop/compare.php' );
        }
        add_action( 'yolo_woocommerce_product_actions', 'yolo_woocomerce_template_loop_compare', 10 );
    }

    /*================================================
    7. WISHLISH AJAX @TODO: move to action.php
    ================================================== */
    function yolo_woocommerce_wishlist(){
        if( !(class_exists( 'WooCommerce' ) && class_exists('YITH_WCWL')) ){
            return;
        }
        
        ob_start();
        
        $wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
        if( function_exists( 'icl_object_id' ) ){
            $wishlist_page_id = icl_object_id( $wishlist_page_id, 'page', true );
        }
        $wishlist_page = get_permalink( $wishlist_page_id );
        
        $count = yith_wcwl_count_products();
        
        ?>
        
        <a title="<?php esc_html_e( 'Wishlist','yolo-motor' ); ?>" href="<?php echo esc_url($wishlist_page); ?>" class="yolo-wishlist">
            <i class="wicon fa fa-heart-o"></i>
            <?php echo '<span class="total">' . ($count > 0 ? $count : '0') . '</span>'; ?>
        </a>

        <?php
        $yolo_wishlist = ob_get_clean();
        return $yolo_wishlist;
    }


    function yolo_update_woocommerce_wishlist() {
        die(yolo_woocommerce_wishlist());
    }

    add_action('wp_ajax_update_woocommerce_wishlist', 'yolo_update_woocommerce_wishlist');
    add_action('wp_ajax_nopriv_update_woocommerce_wishlist', 'yolo_update_woocommerce_wishlist');


    /*-------------------------------------------------------------------------------
    8. Add style attribute types on woocommerce taxonomy
    ------------------------------------------------------------------------------- */

    if ( ! function_exists( 'yolo_admin_style_attributes_types' ) ) :

        function yolo_admin_style_attributes_types( $current ) {

            $current[ 'color' ] = esc_html__( 'Color', 'yolo-motor' );
            $current[ 'image' ] = esc_html__( 'Image', 'yolo-motor' );
            $current[ 'label' ] = esc_html__( 'Label', 'yolo-motor' );

            return $current;
        }

        add_filter( 'product_attributes_type_selector', 'yolo_admin_style_attributes_types' );
    endif;

    //-------------------------------------------------------------------------------
    // 9. Get a Attribute taxonomy values
    //-------------------------------------------------------------------------------

    if ( ! function_exists( 'yolo_get_wc_attribute_taxonomy' ) ):

        function yolo_get_wc_attribute_taxonomy( $attribute_name ) {

            global $wpdb;

            $attr_prefix        = wc_attribute_taxonomy_name( '' );
            $attribute_name     = esc_sql( str_ireplace( $attr_prefix, '', $attribute_name ) );
            $attribute_taxonomy = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name='{$attribute_name}'" );

            return $attribute_taxonomy;
        }
    endif;

    //-------------------------------------------------------------------------------
    // 10. Set style attribute on product admin page
    //-------------------------------------------------------------------------------

    if ( ! function_exists( 'yolo_admin_style_attributes_values' ) ) :

        function yolo_admin_style_attributes_values( $tax, $i ) {

            global $woocommerce, $thepostid;
            if ( in_array( $tax->attribute_type, array( 'color', 'image', 'label' ) ) ) {
                $taxonomy = wc_attribute_taxonomy_name( $tax->attribute_name );
                ?>
                <select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'yolo-motor' ); ?>"
                        class="multiselect attribute_values wc-enhanced-select"
                        name="attribute_values[<?php echo $i; ?>][]">
                    <?php
                        $all_terms = get_terms( $taxonomy, 'orderby=name&hide_empty=0' );
                        if ( $all_terms ) {
                            foreach ( $all_terms as $term ) {
                                echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy, $thepostid ), TRUE, FALSE ) . '>' . $term->name . '</option>';
                            }
                        }
                    ?>
                </select>
                <button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'yolo-motor' ); ?></button>
                <button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'yolo-motor' ); ?></button>
                <button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'yolo-motor' ); ?></button>
                <?php
            }
        }

        add_action( 'woocommerce_product_option_terms', 'yolo_admin_style_attributes_values', 10, 2 );

    endif;

    //-------------------------------------------------------------------------------
    // 11. Color Variation Attribute Options
    //-------------------------------------------------------------------------------

    if ( ! function_exists( 'yolo_wc_color_variation_attribute_options' ) ) :

        /**
         * Output a list of variation attributes for use in the cart forms.
         *
         * @param array $args
         *
         * @since 2.4.0
         */
        function yolo_wc_color_variation_attribute_options( $args = array() ) {

            $args = wp_parse_args( $args, array(
                'options'          => FALSE,
                'attribute'        => FALSE,
                'product'          => FALSE,
                'selected'         => FALSE,
                'name'             => '',
                'id'               => '',
                'class'            => '',
                'show_option_none' => esc_html__( 'Choose an option', 'yolo-motor' )
            ) );

            $options   = $args[ 'options' ];
            $product   = $args[ 'product' ];
            $attribute = $args[ 'attribute' ];
            $name      = $args[ 'name' ] ? $args[ 'name' ] : 'attribute_' . sanitize_title( $attribute );
            $id        = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute ) . $product->id;
            $class     = $args[ 'class' ];

            if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
                $attributes = $product->get_variation_attributes();
                $options    = $attributes[ $attribute ];
            }

            echo '<select ' . $id . ' class="' . esc_attr( $class ) . ' hide" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

            if ( $args[ 'show_option_none' ] ) {
                echo '<option value="">' . esc_html( $args[ 'show_option_none' ] ) . '</option>';
            }

            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    // Get terms if this is a taxonomy - ordered. We need the names too.
                    $terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, FALSE ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                        }
                    }
                }
            }

            echo '</select>';

            echo '<ul class="list-inline variable-items-wrapper color-variable-wrapper">';
            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    $terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            $get_term_meta  = yolo_get_term_meta( $term->term_id, 'product_attribute_color', TRUE );
                            $selected_class = ( sanitize_title( $args[ 'selected' ] ) == $term->slug ) ? 'selected' : '';
                            ?>
                            <li data-toggle="tooltip" data-placement="top"
                                class="variable-item color-variable-item color-variable-item-<?php echo $term->slug ?> <?php echo $selected_class ?>"
                                title="<?php echo esc_html( $term->name ) ?>"
                                style="background-color:<?php echo esc_attr( $get_term_meta ) ?>;"
                                data-value="<?php echo esc_attr( $term->slug ) ?>"></li>
                            <?php
                        }
                    }
                }
            }
            echo '</ul>';
        }

    endif;

    //-------------------------------------------------------------------------------
    // 12. Image Variation Attribute Options
    //-------------------------------------------------------------------------------

    if ( ! function_exists( 'yolo_wc_image_variation_attribute_options' ) ) :

        /**
         * Output a list of variation attributes for use in the cart forms.
         *
         * @param array $args
         *
         * @since 2.4.0
         */
        function yolo_wc_image_variation_attribute_options( $args = array() ) {

            $args = wp_parse_args( $args, array(
                'options'          => FALSE,
                'attribute'        => FALSE,
                'product'          => FALSE,
                'selected'         => FALSE,
                'name'             => '',
                'id'               => '',
                'class'            => '',
                'show_option_none' => esc_html__( 'Choose an option', 'yolo-motor' )
            ) );

            $options   = $args[ 'options' ];
            $product   = $args[ 'product' ];
            $attribute = $args[ 'attribute' ];
            $name      = $args[ 'name' ] ? $args[ 'name' ] : 'attribute_' . sanitize_title( $attribute );
            $id        = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute ) . $product->id;
            $class     = $args[ 'class' ];

            if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
                $attributes = $product->get_variation_attributes();
                $options    = $attributes[ $attribute ];
            }

            echo '<select ' . $id . ' class="' . esc_attr( $class ) . ' hide" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

            if ( $args[ 'show_option_none' ] ) {
                echo '<option value="">' . esc_html( $args[ 'show_option_none' ] ) . '</option>';
            }

            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    // Get terms if this is a taxonomy - ordered. We need the names too.
                    $terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, FALSE ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                        }
                    }
                }
            }

            echo '</select>';

            echo '<ul class="list-inline variable-items-wrapper image-variable-wrapper">';
            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    $terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            $get_term_meta  = yolo_get_term_meta( $term->term_id, 'product_attribute_image', TRUE );
                            $image          = wp_get_attachment_image_src( $get_term_meta, 'full' );
                            $selected_class = ( sanitize_title( $args[ 'selected' ] ) == $term->slug ) ? 'selected' : '';
                            ?>
                            <li data-toggle="tooltip" data-placement="top"
                                class="variable-item image-variable-item image-variable-item-<?php echo $term->slug ?> <?php echo $selected_class ?>"
                                title="<?php echo esc_html( $term->name ) ?>"
                                data-value="<?php echo esc_attr( $term->slug ) ?>"><img
                                    alt="<?php echo esc_html( $term->name ) ?>"
                                    src="<?php echo esc_url( $image[ 0 ] ) ?>"></li>
                            <?php
                        }
                    }
                }
            }
            echo '</ul>';
        }
    endif;

    //-------------------------------------------------------------------------------
    // 13. Label Variation Attribute Options
    //-------------------------------------------------------------------------------

    if ( ! function_exists( 'yolo_wc_label_variation_attribute_options' ) ) :

        /**
         * Output a list of variation attributes for use in the cart forms.
         *
         * @param array $args
         *
         * @since 2.4.0
         */
        function yolo_wc_label_variation_attribute_options( $args = array() ) {

            $args = wp_parse_args( $args, array(
                'options'          => FALSE,
                'attribute'        => FALSE,
                'product'          => FALSE,
                'selected'         => FALSE,
                'name'             => '',
                'id'               => '',
                'class'            => '',
                'show_option_none' => esc_html__( 'Choose an option', 'yolo-motor' )
            ) );

            $options   = $args[ 'options' ];
            $product   = $args[ 'product' ];
            $attribute = $args[ 'attribute' ];
            $name      = $args[ 'name' ] ? $args[ 'name' ] : 'attribute_' . sanitize_title( $attribute );
            $id        = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute ) . $product->id;
            $class     = $args[ 'class' ];

            if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
                $attributes = $product->get_variation_attributes();
                $options    = $attributes[ $attribute ];
            }

            echo '<select ' . $id . ' class="' . esc_attr( $class ) . ' hide" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

            if ( $args[ 'show_option_none' ] ) {
                echo '<option value="">' . esc_html( $args[ 'show_option_none' ] ) . '</option>';
            }

            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    // Get terms if this is a taxonomy - ordered. We need the names too.
                    $terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, FALSE ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                        }
                    }
                }
            }

            echo '</select>';

            echo '<ul class="list-inline variable-items-wrapper label-variable-wrapper">';
            if ( ! empty( $options ) ) {
                if ( $product && taxonomy_exists( $attribute ) ) {
                    $terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( in_array( $term->slug, $options ) ) {
                            $get_term_meta  = yolo_get_term_meta( $term->term_id, 'product_attribute_label', TRUE );
                            $selected_class = ( sanitize_title( $args[ 'selected' ] ) == $term->slug ) ? 'selected' : '';
                            ?>
                            <li data-toggle="tooltip" data-placement="top"
                                class="variable-item label-variable-item label-variable-item-<?php echo $term->slug ?> <?php echo $selected_class ?>"
                                title="<?php echo esc_html( $term->name ) ?>"
                                data-value="<?php echo esc_attr( $term->slug ) ?>"><?php echo esc_html( $term->name ) ?></li>
                            <?php
                        }
                    }
                }
            }
            echo '</ul>';
        }

    endif;

    /*================================================
    RESET LOOP
    ================================================== */
    if (!function_exists('yolo_woocommerce_reset_loop')) {
        function yolo_woocommerce_reset_loop() {
            global $yolo_woocommerce_loop;
            $yolo_woocommerce_loop['layout']          = '';
            $yolo_woocommerce_loop['single_columns']  = '';
            $yolo_woocommerce_loop['columns']         = '';
            $yolo_woocommerce_loop['rating']          = '';
            $yolo_woocommerce_loop['autoPlay']        = 'false';
            $yolo_woocommerce_loop['transitionStyle'] = 'false';
            $yolo_woocommerce_loop['autoHeight']      = 'false';
        }
    }

    /*================================================
    LOOP CATEGORY TEMPLATE
    ================================================== */
    if (!function_exists('yolo_woocommerce_template_loop_category')) {
        function yolo_woocommerce_template_loop_category() {
            wc_get_template( 'loop/category.php' );
        }
        // add_action('woocommerce_after_shop_loop_item_title','yolo_woocommerce_template_loop_category',1);
    }

    /*================================================
    LOOP LINK TEMPLATE
    ================================================== */
    if (!function_exists('yolo_woocomerce_template_loop_link')) {
        function yolo_woocomerce_template_loop_link() {
            wc_get_template( 'loop/link.php' );
        }
        add_action('woocommerce_before_shop_loop_item_title','yolo_woocomerce_template_loop_link',20);
    }
	
    // Before shop loop item
    // remove_all_actions('woocommerce_before_shop_loop_item', 5);
    // add_action( 'woocommerce_before_shop_loop_item', 'yolo_woocommerce_before_shop_loop_item', 5 );
    // if (!function_exists('yolo_woocommerce_before_shop_loop_item')) {
    //     function yolo_woocommerce_before_shop_loop_item() {
    //         echo "something";
    //     }
    // }

    /*================================================
    FILTER PRODUCTS PER PAGE
    ================================================== */
    if (!function_exists('yolo_show_products_per_page')) {
        function yolo_show_products_per_page() {
            $yolo_options = yolo_get_options();
            $product_per_page = $yolo_options['product_per_page'];
            if (empty($product_per_page)) {
                $product_per_page = 12;
            }
            $page_size = isset($_GET['page_size']) ? wc_clean($_GET['page_size']) : $product_per_page;
            return $page_size;
        }
        add_filter('loop_shop_per_page', 'yolo_show_products_per_page');
    }


    /*================================================
    OVERWRITE LOOP PRODUCT THUMBNAIL
    ================================================== */
    if (!function_exists('woocommerce_template_loop_product_thumbnail')) {
        /**
         * Get the product thumbnail for the loop.
         *
         * @access public
         * @subpackage    Loop
         * @return void
         */
        function woocommerce_template_loop_product_thumbnail() {
            global $product;
            $attachment_ids    = $product->get_gallery_attachment_ids();
            $secondary_image   = '';
            $class             = 'product-thumb-one';
            $post_thumbnail_id = '';
            if (has_post_thumbnail()) {
                $post_thumbnail_id = get_post_thumbnail_id();
            }

            $secondary_image_id = '';

            if ($product->product_type == 'variable') {
                $available_variations = $product->get_available_variations();
                if (isset($available_variations)){
                    foreach ($available_variations as $available_variation){
                        $variation_id = $available_variation['variation_id'];
                        if (has_post_thumbnail($variation_id)) {
                            $variation_image_id = get_post_thumbnail_id($variation_id);
                            if ($variation_image_id != $post_thumbnail_id) {
                                $secondary_image_id = $variation_image_id;
                                break;
                            }
                        }
                    }
                }
            }

            if (($secondary_image_id == '') && isset($attachment_ids) && isset($attachment_ids['0'])) {
                $secondary_image_id = $attachment_ids['0'];
            }

	        if (!empty($secondary_image_id)) {
		        $secondary_image    = wp_get_attachment_image( $secondary_image_id, apply_filters( 'shop_catalog', 'shop_catalog' ) );
		        if ( ! empty( $secondary_image ) ) {
			        $class = 'product-thumb-primary';
		        }
	        }
            ?>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="<?php echo esc_attr( $class ); ?>">
                    <?php echo woocommerce_get_product_thumbnail(); ?>
                </div>
            <?php endif; ?>
        <?php
        }
    }

    /*================================================
    OVERWRITE LOOP PRODUCT CREATIVE THUMBNAIL
    ================================================== */
    if (!function_exists('woocommerce_template_loop_product_creative_thumbnail')) {
        /**
         * Get the product thumbnail for the loop.
         *
         * @access public
         * @subpackage    Loop
         * @return void
         */
        function woocommerce_template_loop_product_creative_thumbnail() {
            global $product;

            $post_attachment_id = has_post_thumbnail() ?  get_post_thumbnail_id(): 0;
            $attachment_ids  = $product->get_gallery_attachment_ids();
            $secondary_image = $primary_image = '';
            $class           = 'product-thumb-one';

            $secondary_image_id = '';
            if (isset($attachment_ids) && isset($attachment_ids['0'])) {
                $secondary_image_id = $attachment_ids['0'];
            }
            $width_mobile = $width = 570;
            $height_mobile = $height = 570;


            $matrix = array(
                '2' => array(
                    array(2,1,1.5),
                    array(1,1,1)
                ),
                '3' => array(
                    array(2,1,1),
                    array(2,1,1)
                )
            );
            global $yolo_woocommerce_loop;
            $index = $yolo_woocommerce_loop['post_index'];
            $columns = $yolo_woocommerce_loop['columns'];
            if($columns==2){
                $index_row = floor(($index-1) / 3)%2;
                $index_col = ($index-1) % 3;
                if($index_row==1 && $index_col==2)
                {
                    $yolo_woocommerce_loop['post_index'] = 1;
                    $index_row = 0;
                    $index_col = 0;
                }
                if($matrix[$columns][$index_row][$index_col]==1.5){
                    $width = 270;
                    $height = 468;
                }
            }
            if (!empty($secondary_image_id)) {
                $secondary_image = matthewruddy_image_resize_id($secondary_image_id, $width, $height);
                if ( ! empty( $secondary_image ) ) {
                    $class = 'product-thumb-primary';
                }
                if($columns==2 && $matrix[$columns][$index_row][$index_col]==1.5){
                    $secondary_image_mobile =  matthewruddy_image_resize_id($secondary_image_id, $width_mobile, $height_mobile);
                }
            }
            if($post_attachment_id>0){
                $primary_image = matthewruddy_image_resize_id($post_attachment_id, $width, $height);
                if($columns==2 && $matrix[$columns][$index_row][$index_col]==1.5){
                    $primary_image_mobile =  matthewruddy_image_resize_id($post_attachment_id, $width_mobile, $height_mobile);
                }
            }else{
                $primary_image = $secondary_image;
            }
            ?>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="<?php echo esc_attr( $class ); ?>">
                   <img class="attachment-shop_catalog wp-post-image" width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" alt="<?php echo esc_attr($product->get_title()) ?>" src="<?php echo esc_url($primary_image) ?>">
                   <?php if($columns==2 && $matrix[$columns][$index_row][$index_col]==1.5){?>
                       <img class="attachment-shop_catalog wp-post-image mobile-mode" width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" alt="<?php echo esc_attr($product->get_title()) ?>" src="<?php echo esc_url($primary_image_mobile) ?>">
                   <?php }?>
                </div>
            <?php endif; ?>
        <?php
        }
    }

    /*================================================
    SINGLE PRODUCT
    ================================================== */


    if (!function_exists('yolo_related_products_args')) {
        function yolo_related_products_args() {
	        $yolo_options = yolo_get_options();
	        $args['posts_per_page'] = isset($yolo_options['related_product_count']) ? $yolo_options['related_product_count'] :  8;
	        return $args;
        }
        add_filter('woocommerce_output_related_products_args', 'yolo_related_products_args');
    }

	if (!function_exists('yolo_woocommerce_product_related_posts_relate_by_category')) {
		function yolo_woocommerce_product_related_posts_relate_by_category() {
			$yolo_options = yolo_get_options();
			return $yolo_options['related_product_condition']['category'] == 1 ? true : false;
		}
		add_filter('woocommerce_product_related_posts_relate_by_category','yolo_woocommerce_product_related_posts_relate_by_category');
	}

	if (!function_exists('yolo_woocommerce_product_related_posts_relate_by_tag')) {
		function yolo_woocommerce_product_related_posts_relate_by_tag() {
			$yolo_options = yolo_get_options();
			return $yolo_options['related_product_condition']['tag'] == 1 ? true : false;
		}
		add_filter('woocommerce_product_related_posts_relate_by_tag','yolo_woocommerce_product_related_posts_relate_by_tag');
	}


    /*================================================
    SHOPPING CART
    ================================================== */
    remove_action('woocommerce_cart_collaterals','woocommerce_cross_sell_display');
    add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display',15 );
    add_action('woocommerce_before_cart_totals','woocommerce_shipping_calculator',5);

    if (!function_exists('yolo_button_continue_shopping')) {
        function yolo_button_continue_shopping () {
            $continue_shopping =  get_permalink( wc_get_page_id( 'shop' ) );
            ?>
            <a href="<?php echo esc_url($continue_shopping); ?>" class="continue-shopping button"><?php esc_html_e( 'Continue shopping', 'yolo-motor' ); ?></a>
            <?php
        }
    }

    

	/*================================================
	QUICK VIEW
	================================================== */
	add_action('yolo_before_quick_view_product_summary','woocommerce_show_product_sale_flash',10);

	if (!function_exists('yolo_quick_view_product_images')) {
		function yolo_quick_view_product_images() {
			wc_get_template('quick-view/product-image.php');
		}
		add_action('yolo_before_quick_view_product_summary','yolo_quick_view_product_images',20);
	}

    if (!function_exists('yolo_template_quick_view_product_title')) {
        function yolo_template_quick_view_product_title() {
            wc_get_template( 'quick-view/title.php' );
        }
        add_action('yolo_quick_view_product_summary','yolo_template_quick_view_product_title',5);
    }

    if (!function_exists('yolo_template_quick_view_product_rating')) {
        function yolo_template_quick_view_product_rating() {
            wc_get_template( 'quick-view/rating.php' );
        }
        add_action('yolo_quick_view_product_summary','yolo_template_quick_view_product_rating',15);
    }

    add_action('yolo_quick_view_product_summary','woocommerce_template_single_price',10);
    add_action('yolo_quick_view_product_summary','woocommerce_template_single_excerpt',20);
    add_action('yolo_quick_view_product_summary','woocommerce_template_single_add_to_cart',30);
    add_action('yolo_quick_view_product_summary','woocommerce_template_single_meta',40);
    add_action('yolo_quick_view_product_summary','woocommerce_template_single_sharing',50);


    /*================================================
	CUSTOM WOOCOMERCE CATALOG ORDERING
	================================================== */
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

    add_action( 'yolo_before_shop_loop', 'woocommerce_result_count', 20 );
    add_action( 'yolo_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


    /*================================================
	SHOP PAGE CONTENT
	================================================== */
    if (!function_exists('yolo_shop_page_content')) {
        $yolo_options = yolo_get_options();
        function yolo_shop_page_content() {
            $yolo_options = yolo_get_options();
            $show_page_shop_content = isset($yolo_options['show_page_shop_content']) ? $yolo_options['show_page_shop_content'] : '0';
            if ($show_page_shop_content == '0') return;
            $page_shop_id =  wc_get_page_id('shop');
            if ($page_shop_id == -1) return;
            $myClass = array('shop-page-content-wrapper');
            $myClass[] = 'shop-page-content-'.$show_page_shop_content;
            $query = new WP_Query('page_id='.$page_shop_id);
            if ($query->have_posts()) {
                ?>
                    <div class="<?php echo join(' ',$myClass) ?>">
                        <?php while ($query->have_posts()) : $query->the_post() ; ?>
                            <?php the_content(); ?>
                        <?php endwhile; ?>
                    </div>
                <?php
            }
            wp_reset_postdata();
        }
        $show_page_shop_content = isset($yolo_options['show_page_shop_content']) ? $yolo_options['show_page_shop_content'] : '0';
        if ($show_page_shop_content == 'before') {
            add_action('yolo_before_archive_product_listing','yolo_shop_page_content',5);
        }

        if ($show_page_shop_content == 'after') {
            add_action('yolo_after_archive_product_listing','yolo_shop_page_content',5);
        }

    }

    /*================================================
	ADD EXTEND CLASS IN POPUP COMPARE
	================================================== */
    if (!function_exists('yolo_compare_body_class')) {
        function yolo_compare_body_class($classes) {
            $classes[] = 'woocommerce';
            $action = isset($_GET['action']) ? $_GET['action'] : '';
            if (isset($action)) {
                switch ($action) {
                    case 'yith-woocompare-view-table':
                        $classes[] = 'woocommerce-compare-page';
                        break;
                }
            }
            return $classes;
        }
        add_filter('body_class', 'yolo_compare_body_class');
    }


    /*================================================
    SINGLE PRODUCT FUNCTIONS
    ================================================== */
    if (!function_exists('yolo_woocommerce_template_single_function')) {
        function yolo_woocommerce_template_single_function() {
            wc_get_template( 'single-product/product-function.php' );
        }
        add_action('woocommerce_single_product_summary','yolo_woocommerce_template_single_function',35);
    }

    /*================================================
    PRODUCT ADD TO CART OPTIONS
    ================================================== */
    $product_add_to_cart = isset($yolo_options['product_add_to_cart']) ? $yolo_options['product_add_to_cart'] : true;
    if ($product_add_to_cart == true) {
        add_action('yolo_woocommerce_product_actions','woocommerce_template_loop_add_to_cart',20);
    }
    if ($product_add_to_cart == false) {
        remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
    }

    /*================================================
    ADD META NEW - HOT
    ================================================== */
    // Display Fields
    if (!function_exists('yolo_woocommerce_add_custom_general_fields')) {
        function yolo_woocommerce_add_custom_general_fields() {
            echo '<div class="options_group">';
            woocommerce_wp_checkbox(
                array(
                    'id'    => 'yolo_product_new',
                    'label' => esc_html__( 'Product New', 'yolo-motor' )
                )
            );
            woocommerce_wp_checkbox(
                array(
                    'id'    => 'yolo_product_hot',
                    'label' => esc_html__( 'Product Hot', 'yolo-motor' )
                )
            );
            echo '</div>';
        }
        add_action('woocommerce_product_options_general_product_data', 'yolo_woocommerce_add_custom_general_fields');
    }

    // Save Fields
    if (!function_exists('yolo_woocommerce_add_custom_general_fields_save')) {
        function yolo_woocommerce_add_custom_general_fields_save($post_id) {
            $yolo_product_new = isset($_POST['yolo_product_new']) ? 'yes' : 'no';
            update_post_meta($post_id, 'yolo_product_new', $yolo_product_new);

            $yolo_product_hot = isset($_POST['yolo_product_hot']) ? 'yes' : 'no';
            update_post_meta($post_id, 'yolo_product_hot', $yolo_product_hot);
        }
        add_action('woocommerce_process_product_meta', 'yolo_woocommerce_add_custom_general_fields_save');
    }

    //Add custom column into Product Page
    if (!function_exists('yolo_columns_into_product_list')) {
        function yolo_columns_into_product_list($defaults) {
            $defaults['yolo_product_new'] = esc_html__('New','yolo-motor');
            $defaults['yolo_product_hot'] = esc_html__('Hot','yolo-motor');
            return $defaults;
        }
        add_filter('manage_edit-product_columns', 'yolo_columns_into_product_list');
    }


    //Add rows value into Product Page
    if (!function_exists('yolo_column_into_product_list')) {
        function yolo_column_into_product_list($column, $post_id) {
            switch ($column) {
                case 'yolo_product_new':
                    echo get_post_meta($post_id, 'yolo_product_new', true);
                    break;
                case 'yolo_product_hot':
                    echo get_post_meta($post_id, 'yolo_product_hot', true);
                    break;
            }
        }
        add_action('manage_product_posts_custom_column', 'yolo_column_into_product_list', 10, 2);
    }



    // Make these columns sortable
    if (!function_exists('yolo_sortable_columns')) {
        function yolo_sortable_columns() {
            return array(
                'yolo_product_new' => 'yolo_product_new',
                'yolo_product_hot' => 'yolo_product_hot'
            );
        }
        //add_filter("manage_edit-product_sortable_columns", "yolo_sortable_columns");
    }

    if (!function_exists('yolo_event_column_orderby')) {
        function yolo_event_column_orderby($query) {
            if (!is_admin()) return;
            $orderby = $query->get('orderby');
            if ('yolo_product_new' == $orderby) {
                $query->set('meta_key', 'yolo_product_new');
                $query->set('orderby', 'meta_value_num');
            }

            if ('yolo_product_hot' == $orderby) {
                $query->set('meta_key', 'yolo_product_hot');
                $query->set('orderby', 'meta_value_num');
            }
        }
       // add_action('pre_get_posts', 'yolo_event_column_orderby');
    }
    /*================================================
    ADD META NEW - HOT END
    ================================================== */

    /*================================================
    ADVANCED SEARCH CATEGORY
    ================================================== */
    if (!function_exists('yolo_advanced_search_category_query')) {
        function yolo_advanced_search_category_query($query) {
            if($query->is_search()) {
                // category terms search.
                if (isset($_GET['product_cat']) && !empty($_GET['product_cat'])) {
                    $query->set('tax_query', array(array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => array($_GET['product_cat']) )
                    ));
                }
                return $query;
            }
        }
        add_action('pre_get_posts', 'yolo_advanced_search_category_query', 1000);
    }

    /*================================================
    SHARE
    ================================================== */
    add_action('woocommerce_share','yolo_share',10);

    if (!function_exists('yolo_woocommerce_checkout_title')) {
        function yolo_woocommerce_checkout_title() {
            wc_get_template( 'checkout/title.php');
        }
        add_action('woocommerce_before_checkout_form','yolo_woocommerce_checkout_title',5);
    }


    if (!function_exists('yolo_woocommerce_before_customer_login_form')) {
        function yolo_woocommerce_before_customer_login_form() {
            echo '<div class="customer_login_form_wrap">';
        }
        add_action('woocommerce_before_customer_login_form','yolo_woocommerce_before_customer_login_form',10);
    }

    if (!function_exists('yolo_woocommerce_after_customer_login_form')) {
        function yolo_woocommerce_after_customer_login_form() {
            echo '</div>';
        }
        add_action('woocommerce_after_customer_login_form','yolo_woocommerce_after_customer_login_form',10);
    }

    // Paging Load More Product
    //--------------------------------------------------------------
    if (!function_exists('yolo_paging_load_more_product')) {
        function yolo_paging_load_more_product($products) {
            // Don't print empty markup if there's only one page.
            if ( $products->max_num_pages < 2 ) {
                return;
            }
            $link = get_next_posts_page_link($products->max_num_pages);
            if (!empty($link)) :
                ?> 
                    <button data-href="<?php echo esc_url($link); ?>" type="button"  data-loading-text="<span class='fa fa-spinner fa-spin'></span> <?php esc_html_e( "Loading...",'yolo-motor' ); ?>" class="product-load-more motor-button style1 button-2x" autocomplete="off">
                        <?php esc_html_e( "Load More", 'yolo-motor' ); ?>
                    </button>
            <?php
            endif;
        }
    }
    // Paging Infinite Scroll Product
    //--------------------------------------------------------------
    if ( ! function_exists('yolo_paging_infinitescroll_product') ) {
        function yolo_paging_infinitescroll_product($products) {
            // Don't print empty markup if there's only one page.
            if ( $products->max_num_pages < 2 ) {
                return;
            }
            $link = get_next_posts_page_link($products->max_num_pages);
            if (!empty($link)) :
                ?>
                <nav id="infinite_scroll_button">
                    <a href="<?php echo esc_url($link); ?>"></a>
                </nav>
                <div id="infinite_scroll_loading" class="text-center infinite-scroll-loading"></div>
            <?php
            endif;
        }
    }

    // Paging Nav Product
    //--------------------------------------------------------------
    if ( ! function_exists( 'yolo_paging_nav_product' ) ) {
        function yolo_paging_nav_product($products) {
            global $wp_rewrite;
            // Don't print empty markup if there's only one page.
            if ( $products->max_num_pages < 2 ) {
                return;
            }

            $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
            $pagenum_link = html_entity_decode( get_pagenum_link() );
            $query_args   = array();
            $url_parts    = explode( '?', $pagenum_link );

            if ( isset( $url_parts[1] ) ) {
                wp_parse_str( $url_parts[1], $query_args );
            }

            $pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
            $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

            $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
            $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

            // Set up paginated links.
            $page_links = paginate_links( array(
                'base'      => $pagenum_link,
                'format'    => $format,
                'total'     => $products->max_num_pages,
                'current'   => $paged,
                'mid_size'  => 1,
                'add_args'  => array_map( 'urlencode', $query_args ),
                'prev_text' => esc_html__('Prev', 'yolo-motor'),
                'next_text' => esc_html__('Next', 'yolo-motor'),
                'type'      => 'array'
            ) );

            if (count($page_links) == 0) return;

            $links = "<div class='woocommerce-pagination'>";
            $links .= "<ul class='pagination'>\n\t<li>";
            $links .= join("</li>\n\t<li>", $page_links);
            $links .= "</li>\n</ul>\n";
            $links .= "</div>";

            return $links;
        }
    }
    /*
     *  Category menu: Output product categories menu
     */
    
    function yolo_category_menu() {
       global $wp_query,$post;
       $list_args          = array( 'show_count' => 0, 'hierarchical' => 1, 'taxonomy' => 'product_cat', 'hide_empty' => 1 );
       $cat_ancestor = array();
       $cat_all = 1;
       $page_shop_id =  get_option( 'woocommerce_shop_page_id' );
       $page_shop_url = '';
       if(isset($page_shop_id) && !empty($page_shop_id)){
            $page_shop_url = get_permalink($page_shop_id );
       }
        $current_id = '';
        $current_class = '';
        if(is_product_category()){
            $current_id = $wp_query->queried_object;
            $cat_ancestor = get_ancestors( $current_id->term_id, 'product_cat' );
        }else{
            $current_class = "current-cat";
            $product_category = wc_get_product_terms( $post->ID, 'product_cat', apply_filters( 'woocommerce_product_categories_widget_product_terms_args', array( 'orderby' => 'parent' ) ) );

            if ( ! empty( $product_category ) ) {
                $current_id   = end( $product_category );
                $cat_ancestors = get_ancestors( $current_id->term_id, 'product_cat' );
            }
        }
        $list_args['title_li']                   = '';
        $list_args['pad_counts']                 = 1;
        $list_args['show_option_none']           = esc_html__('No product categories exist.', 'yolo-motor' );
        // $list_args['current_category']        = ( $current_id ) ? $current_id->term_id : '';
        $list_args['current_category_ancestors'] = $cat_ancestor;
        echo '<h4 class = "yolo-filter-categories-mobile">'.esc_html__('Categories','yolo-motor').'</h4>';
        echo '<ul class="yolo-filter-categories">';
            echo '<li class="'.$current_class.'"><a href="' .esc_url($page_shop_url).'">' . esc_html__( 'All', 'yolo-motor') . '</a></li>';
            wp_list_categories( apply_filters( 'woocommerce_product_categories_filter', $list_args ) );
        echo  '</ul>';
    }
    /*
     *  Category menu: Output product categories menu (level 2)
     */
    // function yolo_category_menu() {
    //    $categories = get_categories( $args = array(
    //        'type'          => 'post',
    //        'hide_empty'    => 1,
    //        'hierarchical'  => 1,
    //        'taxonomy'      => 'product_cat'
    //    ) );
    //    global $wp_query;
    //    $cat_all = 1;
    //    $page_shop_id =  get_option( 'woocommerce_shop_page_id' );
    //    $page_shop_url = '';
    //    if(isset($page_shop_id) && !empty($page_shop_id)){
    //         $page_shop_url = get_permalink($page_shop_id );
    //    }
    //     $current_id = '';
    //     $current_class = '';
    //     if(is_product_category()){
    //         $current_id = $wp_query->queried_object->term_id;
    //     }else{
    //         $current_class = "current-cat";
    //     }
    //    if($categories):
    //        foreach ( $categories as $key => $val ) {
    //            if (  $val->term_id == $current_id ) {
    //                $cat_all = 0;
    //            }
    //        }
    //    endif;
    //    $output = '<h4 class = "yolo-filter-categories-mobile">'.esc_html__('Categories','yolo-motor').'</h4>';
    //    $output .= '<ul class="yolo-filter-categories">';
    //    if ( $cat_all ) {
    //     $output .= '<li class="'.$current_class.'"><a href="' .esc_url($page_shop_url).'">' . esc_html__( 'All', 'yolo-motor') . '</a></li>'; // @TODO: change shop to get shop page
    //    } else {
    //        $output .= '<li class=""><a href="'.esc_url($page_shop_url).'">' . esc_html__( 'All', 'yolo-motor') . '</a></li>';
    //    }
    //    if( $categories ){
    //        foreach ( $categories as $key => $val ) {
    //            if ( $val->count > 0 ) {
    //                if ( $current_id == $val->term_id ) {
    //                    $output .= '<li class="current-cat">';
    //                } else {
    //                    $output .= '<li class="">';
    //                }
    //                $output .= '<span>/</span>';
    //                $output .= '<a href="'.get_term_link( (int) $val->term_id, 'product_cat' ).'">' . $val->name . '</a>';
    //                $output .= '</li>';
    //            }
    //        }
    //    }
    //    $output .= '</ul>';

    //    return $output;
    // }
    function yolo_active_filters_count() {
        $count = 0;

        // WooCommerce source: "../plugins/woocommerce/includes/widgets/class-wc-widget-layered-nav-filters.php" (line 50)
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $count += isset( $_GET['min_price'] ) ? 1 : 0;
        //$count += isset( $_GET['max_price'] ) ? 1 : 0;
        $count += isset( $_GET['min_rating'] ) ? 1 : 0;
        // /WooCommerce source

        //$count += isset( $_GET['orderby'] ) ? 1 : 0;

        // Count active terms/filters
        foreach ( $_chosen_attributes as $attributes ) {
            $count += count( $attributes['terms'] );
        }

        return $count;
    }
}
