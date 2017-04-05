<?php 
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 29/1/2016
 * Time: 3:00 PM
 */
?>
<?php if( $filter_style != '' && $data_source != 'product_list_id' ) : ?>
<div class="product-filters">
    <ul data-option-key="filter" class="filter-<?php echo esc_attr($filter_align); ?> <?php echo esc_attr($filter_style); ?>">
        <?php if( $show_all_filter == 'show' ) :?>
            <li>
                <a class="selected" href="#" data-option-value="*"><?php echo esc_html__( 'All', 'yolo-motor' ) ?></a>
            </li>
        <?php endif;?>
        <?php
        if ( ! empty($category) ) {
            $category_arr = array_filter(explode(',', $category));
            foreach ((array)$category_arr as $cat) :
                $category = get_term_by('slug', $cat, 'product_cat');
                ?>
                <li>
                    <a href="#" data-option-value=".<?php echo 'product_cat-' . $category->slug ?>"><?php echo esc_html($category->name); ?></a>
                </li>
                <?php
            endforeach;
        } else {
            if ($product_categories = get_terms('product_cat')) {

                foreach ((array)$product_categories as $product_category) {
                    ?>
                    <li>
                        <a href="#"
                           data-option-value=".<?php echo 'product_cat-' . $product_category->slug ?>"><?php echo esc_html($product_category->name); ?></a>
                    </li>
                    <?php
                }
            }
        }
        ?>
        <?php if( $sorting == 'true' ) : ?>
            <li class="bt-order"><?php echo esc_html__( 'Sort by', 'yolo-motor' ); ?></li>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?>

<?php if( $sorting == 'true' ) : ?>
    <div class="product-sort sorting-<?php echo esc_attr($filter_align); ?>">
        <ul class="list-sort">
            <li data-sort-by="title" class="<?php if ($orderby == 'title') { echo 'active'; } ?>"><?php esc_html_e( 'Title', 'yolo-motor' ); ?></li>
            <li data-sort-by="price" class="<?php if ($orderby == 'price') { echo 'active'; } ?>"><?php esc_html_e( 'Price', 'yolo-motor' ); ?></li>
            <li data-sort-by="onsale"><?php esc_html_e( 'Onsale', 'yolo-motor' ); ?></li>
        </ul>
        <div class="asc-desc">
            <select class="select-asc-desc" name="asc-desc">
                <option value="true" <?php if($order == 'asc') { echo 'selected="selected"'; } ?> ><?php esc_html_e( 'ASC', 'yolo-motor' ); ?></option>
                <option value="false" <?php if($order == 'desc') { echo 'selected="selected"';} ?> ><?php esc_html_e( 'DESC', 'yolo-motor' ); ?></option>
            </select>
        </div>
    </div>
<?php endif; ?>

<div class="<?php echo join(' ',$product_wrap_class); ?>">
    <div class="<?php echo join(' ',$product_class); ?>">
        <?php woocommerce_product_loop_start(); ?>
        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
            <?php include($product_path); // From products.php file ?>
        <?php endwhile; // end of the loop. ?>
        <?php woocommerce_product_loop_end(); ?>
    </div>
</div>

<?php if ( $products->max_num_pages > 1 ) : ?>
<div class="<?php echo join(' ', $product_paging_class); ?>">
    <?php
    switch($paging_style) {
        case 'load-more':
            yolo_paging_load_more_product($products);
            break;
        case 'infinity-scroll':
            yolo_paging_infinitescroll_product($products);
            break;
        default:
            echo yolo_paging_nav_product($products);
            break;
    }
    ?>
</div>
<?php endif; ?>

<!-- @TODO: need move it to main.js file -->
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var currency_symbol = '<?php echo html_entity_decode( get_woocommerce_currency_symbol() ); ?>';
        var sorting = <?php echo esc_attr($sorting); ?>;

        /*Click filter*/
        $('.bt-order').click(function(){
            $('.product-sort').slideToggle(300);
            $(this).toggleClass('active');
        });

        // init Isotope
        var $container = $('.product-listing').isotope({ // parent element of .item
            itemSelector: '.product-item-wrap',
            layoutMode: 'fitRows',
            getSortData: {
                // title: '.product-info h3 a',
                title: '.product-name a',
                price: function (itemElem) {
                    var weight = $(itemElem).find('.price ins .amount').text();
                    var weight2 = $(itemElem).find('.price .amount').text();
                    var weight3 = $(itemElem).find('.price ins .amount').first().text();
                    if(weight3){
                        weight = parseFloat(weight3.replace(currency_symbol, ''));
                    } else if (weight) {
                        weight = parseFloat(weight.replace(currency_symbol, ''));
                    } else if (weight2) {
                        weight = parseFloat(weight2.replace(currency_symbol, ''));
                    } else {
                        weight = 0;
                    }
                    return weight;
                },
                onsale: function (itemElem) {
                    var onsale = $(itemElem).find('.onsale').text();
                    return onsale;
                }
            }
        });

        if(sorting == true) {
            var sortByValue = '';
            // bind sort button click
            $('.product-sort .list-sort li').click(function () {
                var selected = $('.select-asc-desc option[selected="selected"]').val();
                if(selected == 'false') {
                    selected = false;
                }
                sortByValue = $(this).attr('data-sort-by');
                
                $('.list-sort li').removeClass('active');
                $(this).addClass('active');
                $container.isotope({
                    sortBy: sortByValue,
                    sortAscending: selected
                });
            });
            /* select asc or desc*/
            $('.select-asc-desc').change(function(){
                var selected = $(this).val();
                $(this).find('option').removeAttr('selected');
                $('.select-asc-desc option').each(function(){
                    if(selected == $(this).val()){
                        $(this).attr('selected','selected');
                    }
                });
                if(selected == 'false'){
                    selected = false;
                }
                $container.isotope({
                    sortBy: sortByValue,
                    sortAscending: selected
                });
            });

            /* default*/
            var default_selected = $('.select-asc-desc option[selected="selected"]').val();
            if(default_selected == 'false'){
                default_selected = false;
            }
            $container.isotope({
                sortAscending: default_selected
            });
        }
    });
</script>