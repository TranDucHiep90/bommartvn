<?php
add_action('admin_enqueue_scripts', 'ds_admin_theme_style');
function ds_admin_theme_style() {
echo '<style>#flatsome-notice{ display: none; }</style>';
}

// Add custom Theme Functions here
function ttit_add_element_ux_builder(){
  add_ux_builder_shortcode('title_with_cat', array(
    'name'      => __('Title With Category'),
    'category'  => __('Content'),
    'info'      => '{{ text }}',
    'wrap'      => false,
    'options' => array(
      'ttit_cat_ids' => array(
        'type' => 'select',
        'heading' => 'Categories',
        'param_name' => 'ids',
        'config' => array(
          'multiple' => true,
          'placeholder' => 'Select...',
          'termSelect' => array(
            'post_type' => 'product_cat',
            'taxonomies' => 'product_cat'
          )
        )
      ),
      'style' => array(
        'type'    => 'select',
        'heading' => 'Style',
        'default' => 'normal',
        'options' => array(
          'normal'      => 'Normal',
          'center'      => 'Center',
          'bold'        => 'Left Bold',
          'bold-center' => 'Center Bold',
        ),
      ),
      'text' => array(
        'type'       => 'textfield',
        'heading'    => 'Title',
        'default'    => 'Lorem ipsum dolor sit amet...',
        'auto_focus' => true,
      ),
      'tag_name' => array(
        'type'    => 'select',
        'heading' => 'Tag',
        'default' => 'h3',
        'options' => array(
          'h1' => 'H1',
          'h2' => 'H2',
          'h3' => 'H3',
          'h4' => 'H4',
        ),
      ),
      'color' => array(
        'type'     => 'colorpicker',
        'heading'  => __( 'Color' ),
        'alpha'    => true,
        'format'   => 'rgb',
        'position' => 'bottom right',
      ),
      'width' => array(
        'type'    => 'scrubfield',
        'heading' => __( 'Width' ),
        'default' => '',
        'min'     => 0,
        'max'     => 1200,
        'step'    => 5,
      ),
      'margin_top' => array(
        'type'        => 'scrubfield',
        'heading'     => __( 'Margin Top' ),
        'default'     => '',
        'placeholder' => __( '0px' ),
        'min'         => - 100,
        'max'         => 300,
        'step'        => 1,
      ),
      'margin_bottom' => array(
        'type'        => 'scrubfield',
        'heading'     => __( 'Margin Bottom' ),
        'default'     => '',
        'placeholder' => __( '0px' ),
        'min'         => - 100,
        'max'         => 300,
        'step'        => 1,
      ),
      'size' => array(
        'type'    => 'slider',
        'heading' => __( 'Size' ),
        'default' => 100,
        'unit'    => '%',
        'min'     => 20,
        'max'     => 300,
        'step'    => 1,
      ),
      'link_text' => array(
        'type'    => 'textfield',
        'heading' => 'Link Text',
        'default' => '',
      ),
      'link' => array(
        'type'    => 'textfield',
        'heading' => 'Link',
        'default' => '',
      ),
    ),
  ));
}
add_action('ux_builder_setup', 'ttit_add_element_ux_builder');

function title_with_cat_shortcode( $atts, $content = null ){
  extract( shortcode_atts( array(
    '_id' => 'title-'.rand(),
    'class' => '',
    'visibility' => '',
    'text' => 'Lorem ipsum dolor sit amet...',
    'tag_name' => 'h3',
    'sub_text' => '',
    'style' => 'normal',
    'size' => '100',
    'link' => '',
    'link_text' => '',
    'target' => '',
    'margin_top' => '',
    'margin_bottom' => '',
    'letter_case' => '',
    'color' => '',
    'width' => '',
    'icon' => '',
  ), $atts ) );
  $classes = array('container', 'section-title-container');
  if ( $class ) $classes[] = $class;
  if ( $visibility ) $classes[] = $visibility;
  $classes = implode(' ', $classes);
  $link_output = '';
  if($link) $link_output = '<a href="'.$link.'" target="'.$target.'">'.$link_text.get_flatsome_icon('icon-angle-right').'</a>';
  $small_text = '';
  if($sub_text) $small_text = '<small class="sub-title">'.$atts['sub_text'].'</small>';
  if($icon) $icon = get_flatsome_icon($icon);
  // fix old
  if($style == 'bold_center') $style = 'bold-center';
  $css_args = array(
   array( 'attribute' => 'margin-top', 'value' => $margin_top),
   array( 'attribute' => 'margin-bottom', 'value' => $margin_bottom),
  );
  if($width) {
    $css_args[] = array( 'attribute' => 'max-width', 'value' => $width);
  }
  $css_args_title = array();
  if($size !== '100'){
    $css_args_title[] = array( 'attribute' => 'font-size', 'value' => $size, 'unit' => '%');
  }
  if($color){
    $css_args_title[] = array( 'attribute' => 'color', 'value' => $color);
  }
  if ( isset( $atts[ 'ttit_cat_ids' ] ) ) {
    $ids = explode( ',', $atts[ 'ttit_cat_ids' ] );
    $ids = array_map( 'trim', $ids );
    $parent = '';
    $orderby = 'include';
  } else {
    $ids = array();
  }
  $args = array(
    'taxonomy' => 'product_cat',
    'include'    => $ids,
    'pad_counts' => true,
    'child_of'   => 0,
  );
  $product_categories = get_terms( $args );
  $hdevvn_html_show_cat = '';
  if ( $product_categories ) {
    foreach ( $product_categories as $category ) {
      $term_link = get_term_link( $category );
      $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
      if ( $thumbnail_id ) {
        $image = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size);
        $image = $image[0];
      } else {
        $image = wc_placeholder_img_src();
      }
      $hdevvn_html_show_cat .= '<li class="hdevvn_cats"><a href="'.$term_link.'">'.$category->name.'</a></li>';
    }
  }
  return '<div class="'.$classes.'" '.get_shortcode_inline_css($css_args).'><'. $tag_name . ' class="section-title section-title-'.$style.'"><b></b><span class="section-title-main" '.get_shortcode_inline_css($css_args_title).'>'.$icon.$text.$small_text.'</span>
  <span class="hdevvn-show-cats">'.$hdevvn_html_show_cat.'</span><b></b>'.$link_output.'</' . $tag_name .'></div><!-- .section-title -->';
}
add_shortcode('title_with_cat', 'title_with_cat_shortcode');


//Thêm nút mua ngay bên cạnh Add to cart//
/*
* Add quick buy button go to checkout after click
* Author: levantoan.com
*/
add_action('woocommerce_after_add_to_cart_button','devvn_quickbuy_after_addtocart_button');
function devvn_quickbuy_after_addtocart_button(){
    global $product;
    ?>
    <style>
        .devvn-quickbuy button.single_add_to_cart_button.loading:after {
            display: none;
        }
        .devvn-quickbuy button.single_add_to_cart_button.button.alt.loading {
            color: #fff;
            pointer-events: none !important;
        }
        .devvn-quickbuy button.buy_now_button {
            position: relative;
            color: rgba(255,255,255,0.05);
        }
        .devvn-quickbuy button.buy_now_button:after {
            animation: spin 500ms infinite linear;
            border: 2px solid #fff;
            border-radius: 32px;
            border-right-color: transparent !important;
            border-top-color: transparent !important;
            content: "";
            display: block;
            height: 16px;
            top: 50%;
            margin-top: -8px;
            left: 50%;
            margin-left: -8px;
            position: absolute;
            width: 16px;
        }
    </style>
    <button type="button" class="button buy_now_button">
        <?php _e('Mua ngay', 'devvn'); ?>
    </button>
    <input type="hidden" name="is_buy_now" class="is_buy_now" value="0" autocomplete="off"/>
    <script>
        jQuery(document).ready(function(){
            jQuery('body').on('click', '.buy_now_button', function(e){
                e.preventDefault();
                var thisParent = jQuery(this).parents('form.cart');
                if(jQuery('.single_add_to_cart_button', thisParent).hasClass('disabled')) {
                    jQuery('.single_add_to_cart_button', thisParent).trigger('click');
                    return false;
                }
                thisParent.addClass('devvn-quickbuy');
                jQuery('.is_buy_now', thisParent).val('1');
                jQuery('.single_add_to_cart_button', thisParent).trigger('click');
            });
        });
    </script>
    <?php
}
add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url) {
    if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now']) {
        $redirect_url = wc_get_checkout_url(); //or wc_get_cart_url()
    }
    return $redirect_url;
}
//ĐỔi tên nút add to cart
// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Thêm vào giỏ', 'woocommerce' ); 
}
// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Thêm vào giỏ', 'woocommerce' );
}

//Thay đổi hiển thị posted on trong  trang chi tiết bài viết//
function flatsome_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }
 
    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( 'c' ) ),
        esc_html( get_the_modified_date() )
    );
 
    $posted_on = sprintf(
        esc_html_x( '%s', 'post date', 'flatsome' ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );
 
    $byline = sprintf(
        esc_html_x( '%s', 'post author', 'flatsome' ),
        '<span class="meta-author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );
    echo '<span class="posted-on"><i class="far fa-calendar-alt"></i>' . $posted_on . '</span><span class="byline"><i class="fa fa-user"></i> ' . $byline . '</span>';
 }
//Xóa tab thông tin bổ sung//
add_filter( 'woocommerce_product_tabs', 'dieuhau_remove_product_tabs', 98 );
function dieuhau_remove_product_tabs( $tabs ) {
   unset( $tabs['additional_information'] );
   return $tabs;
}
//Đổi tên tab thôgn tin chi tiết//
/**
 * Rename product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

    $tabs['description']['title'] = __( 'Thông tin chi tiết' );		// Rename the description tab
    return $tabs;
}
//Thu gọn nội dung mô tả danh mục//
/*
 * Thêm nút Xem thêm vào phần mô tả của danh mục sản phẩm
 * Author: Le Van Toan - https://levantoan.com
*/
add_action('wp_footer','devvn_readmore_taxonomy_flatsome');
function devvn_readmore_taxonomy_flatsome(){
    if(is_woocommerce() && is_tax('product_cat')):
        ?>
        <style>
            .tax-product_cat.woocommerce .shop-container .term-description {
                overflow: hidden;
                position: relative;
                margin-bottom: 20px;
                padding-bottom: 25px;
            }
            .devvn_readmore_taxonomy_flatsome {
                text-align: center;
                cursor: pointer;
                position: absolute;
                z-index: 10;
                bottom: 0;
                width: 100%;
                background: #fff;
            }
            .devvn_readmore_taxonomy_flatsome:before {
                height: 55px;
                margin-top: -45px;
                content: "";
                background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
                background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff00', endColorstr='#ffffff',GradientType=0 );
                display: block;
            }
            .devvn_readmore_taxonomy_flatsome a {
                color: #318A00;
                display: block;
            }
            .devvn_readmore_taxonomy_flatsome a:after {
                content: '';
                width: 0;
                right: 0;
                border-top: 6px solid #318A00;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                display: inline-block;
                vertical-align: middle;
                margin: -2px 0 0 5px;
            }
            .devvn_readmore_taxonomy_flatsome_less:before {
                display: none;
            }
            .devvn_readmore_taxonomy_flatsome_less a:after {
                border-top: 0;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 6px solid #318A00;
            }
        </style>
        <script>
            (function($){
                $(document).ready(function(){
                    $(window).on('load', function(){
                        if($('.tax-product_cat.woocommerce .shop-container .term-description').length > 0){
                            var wrap = $('.tax-product_cat.woocommerce .shop-container .term-description');
                            var current_height = wrap.height();
                            var your_height = 600;
                            if(current_height > your_height){
                                wrap.css('height', your_height+'px');
                                wrap.append(function(){
                                    return '<div class="devvn_readmore_taxonomy_flatsome devvn_readmore_taxonomy_flatsome_show"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                                });
                                wrap.append(function(){
                                    return '<div class="devvn_readmore_taxonomy_flatsome devvn_readmore_taxonomy_flatsome_less" style="display: none"><a title="Thu gọn" href="javascript:void(0);">Thu gọn</a></div>';
                                });
                                $('body').on('click','.devvn_readmore_taxonomy_flatsome_show', function(){
                                    wrap.removeAttr('style');
                                    $('body .devvn_readmore_taxonomy_flatsome_show').hide();
                                    $('body .devvn_readmore_taxonomy_flatsome_less').show();
                                });
                                $('body').on('click','.devvn_readmore_taxonomy_flatsome_less', function(){
                                    wrap.css('height', your_height+'px');
                                    $('body .devvn_readmore_taxonomy_flatsome_show').show();
                                    $('body .devvn_readmore_taxonomy_flatsome_less').hide();
                                });
                            }
                        }
                    });
                });
            })(jQuery);
        </script>
    <?php
    endif;
}

/*
* Author: Le Van Toan - https://levantoan.com
* Đoạn code thu gọn nội dung bao gồm cả nút xem thêm và thu gọn lại sau khi đã click vào xem thêm
*/
add_action('wp_footer','devvn_readmore_flatsome');
function devvn_readmore_flatsome(){
    ?>
    <style>
        .single-product div#tab-description {
            overflow: hidden;
            position: relative;
            padding-bottom: 25px;
        }
        .single-product .tab-panels div#tab-description.panel:not(.active) {
            height: 0 !important;
        }
        .devvn_readmore_flatsome {
            text-align: center;
            cursor: pointer;
            position: absolute;
            z-index: 10;
            bottom: 0;
            width: 100%;
            background: #fff;
        }
        .devvn_readmore_flatsome:before {
            height: 55px;
            margin-top: -45px;
            content: "";
            background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
            background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff00', endColorstr='#ffffff',GradientType=0 );
            display: block;
        }
        .devvn_readmore_flatsome a {
            color: #318A00;
            display: block;
        }
        .devvn_readmore_flatsome a:after {
            content: '';
            width: 0;
            right: 0;
            border-top: 6px solid #318A00;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            display: inline-block;
            vertical-align: middle;
            margin: -2px 0 0 5px;
        }
        .devvn_readmore_flatsome_less a:after {
            border-top: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid #318A00;
        }
        .devvn_readmore_flatsome_less:before {
            display: none;
        }
    </style>
    <script>
        (function($){
            $(document).ready(function(){
                $(window).on('load', function(){
                    if($('.single-product div#tab-description').length > 0){
                        var wrap = $('.single-product div#tab-description');
                        var current_height = wrap.height();
                        var your_height = 600;
                        if(current_height > your_height){
                            wrap.css('height', your_height+'px');
                            wrap.append(function(){
                                return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_more"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                            });
                            wrap.append(function(){
                                return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_less" style="display: none;"><a title="Xem thêm" href="javascript:void(0);">Thu gọn</a></div>';
                            });
                            $('body').on('click','.devvn_readmore_flatsome_more', function(){
                                wrap.removeAttr('style');
                                $('body .devvn_readmore_flatsome_more').hide();
                                $('body .devvn_readmore_flatsome_less').show();
                            });
                            $('body').on('click','.devvn_readmore_flatsome_less', function(){
                                wrap.css('height', your_height+'px');
                                $('body .devvn_readmore_flatsome_less').hide();
                                $('body .devvn_readmore_flatsome_more').show();
                            });
                        }
                    }
                });
            });
        })(jQuery);
    </script>
    <?php
}