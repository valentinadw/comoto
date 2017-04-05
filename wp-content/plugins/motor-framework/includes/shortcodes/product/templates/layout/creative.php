<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 29/1/2016
 * Time: 3:35 PM
 */
$slider_id = uniqid();
// var_dump($category);
// var_dump($per_page);
$random = wp_rand(0,10000);
$class_control = 'yolo-sh-slider';
$style = '';
if( $style =='grid' ){
    $class_control = 'noo-sh-grid columns'.$columns;
}elseif($style == 'grid2'){
    $class_control = 'noo-sh-grid noo-sh-grid2 columns'.$columns;
}else{
    wp_enqueue_script('noo-carousel');
}

?>
<div class="<?php echo join(' ',$product_wrap_class); ?>">

    <div class="products-creative-header clearfix">
        <div class="pull-left">
            <h2 class="products-creative-title">Yolo Creative</h2>
            <h4 class="products-creative-attach">Yolo Description</h4>
        </div>
        <div class="pull-right">
            <?php

            ?>
                <ul class="products-creative-list-cat">
                    <?php
                    if ( ! empty($category) ) :
                        $category_arr = array_filter(explode(',', $category));
                        foreach ((array)$category_arr as $key => $cat) :
                            $category = get_term_by('slug', $cat, 'product_cat');
                            // var_dump($category);
                            if( $key == 0 ) {
                                $cat_id = (int)$category->term_id; // Get First category to display products
                            }
                    ?>
                            <li>
                                 <a href="#" data-value="" data-product-style="<?php echo $product_style; ?>" data-action-disable="<?php echo $action_disable; ?>" data-action-tooltip="<?php echo $action_tooltip; ?>" data-class="<?php echo esc_html($category->slug).'_'.$random; ?>" data-id="<?php echo esc_attr($category->term_id); ?>" data-limit="<?php echo esc_attr($per_page); ?>">
                                     <?php echo esc_html($category->name); ?>
                                </a>
                            </li>
                        <?php 
                        endforeach;
                    endif;
                    ?>
                </ul>
            <?php 
            // } 
            ?>
        </div>
    </div>

    <div id="products-creative-<?php echo $slider_id; ?>" class="products-creative noo-row products-slider <?php echo join(' ',$product_class); ?>">
        <div class="spinner-eff">
            <div class="spinner"></div>
        </div>
        <div class="products-creative-tab <?php echo esc_attr($class_control); ?>">
            <div class="yolo-slider">
                <?php
                $args = array(
                    'post_type'         =>  'product',
                    'orderby'           =>   $orderby,
                    'order'             =>   $order,
                    'posts_per_page'    =>   $per_page
                );


                if( isset($cat_id)  && !empty($cat_id) ){
                    $args['tax_query'][] = array(
                        'taxonomy' =>  'product_cat',
                        'field'    =>  'term_id',
                        'terms'    =>   $cat_id,
                        'operator' =>   'IN'
                    );
                }
                $query = new WP_Query($args) ;
                // var_dump($args);
                // var_dump($query);
                if( $query->have_posts() ):
                    while( $query->have_posts() ): $query->the_post();
                ?>
                    <?php include($product_path); // From products.php file ?>
                    <?php   
                    endwhile;
                endif; wp_reset_postdata();
                ?>
            </div>

        </div><!--end product tab-->
    </div>

</div>