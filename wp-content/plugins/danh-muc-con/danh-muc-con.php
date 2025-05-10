<?php
/**
 * Plugin Name: Danh mục con
 * Plugin URI: https:giuseart.com
 * Description: Hiển thị danh mục con riêng biệt trong trang danh mục sản phẩm
 * Version: 1.0
 * Author: GiuseArt
 * Author URI: http://facebook.com/joseph.thien.75
 *
 *
 */
 function tutsplus_product_cats_css() {
 
    /* register the stylesheet */
    wp_register_style( 'tutsplus_product_cats_css', plugins_url( 'css/style.css', __FILE__ ) );
     
    /* enqueue the stylsheet */
    wp_enqueue_style( 'tutsplus_product_cats_css' );
     
}
 
add_action( 'wp_enqueue_scripts', 'tutsplus_product_cats_css' );

 function tutsplus_product_subcategories( $args = array() ) {
     $parentid = get_queried_object_id();
         
$args = array(
    'parent' => $parentid
);
 
$terms = get_terms( 'product_cat', $args );
 
if ( $terms ) {
    echo '<div class="products row danh-muc-con">';
     
        foreach ( $terms as $term ) {
            echo '<div class="product-category col">';  
                         echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';  echo '<div class="box-image">';
                woocommerce_subcategory_thumbnail( $term );
                 echo '</div>';
                              echo '</a>';
                 echo '<div class="box-text">';
                echo '<h5 class="header-title">';
                echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">'; 
                        echo $term->name;
                    echo '</a>';
                echo '</h5>';
                     echo '</div>';                                                
            echo '</div>';
    }
     
    echo '</div>';
}
    }
add_action( 'woocommerce_before_shop_loop', 'tutsplus_product_subcategories', 50 );