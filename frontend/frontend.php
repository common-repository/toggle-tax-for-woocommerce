<?php

if( ! defined ( 'ABSPATH' ) ){
    exit;
}

if( ! class_exists ('Gt_frontend') ){

    class Gt_frontend {    
        
        public function __construct()
        {
            add_action( 'wp_footer', array($this, 'gt_add_floating_button') );
            add_filter( 'woocommerce_get_price_html', array($this, 'gt_add_prices_data_attributes'), 10, 2 );
            add_action( 'wp_head', array($this, 'gt_style_head') );
        } 
        
        function gt_add_floating_button () { 
            $gt_btn_state = get_option('gt_tax_btn_state') ? get_option('gt_tax_btn_state') : 'show';
            $gt_bg_color = get_option('gt_tax_bg_color') ? get_option('gt_tax_bg_color') : '#333333';
            $gt_text_color = get_option('gt_tax_text_color') ?  get_option('gt_tax_text_color') : '#ffffff';
            $gt_tax_btn_text = get_option('gt_tax_btn_text') ? get_option('gt_tax_btn_text') : 'incl. tax';
            $gt_tax_btn_toggle_text = get_option('gt_tax_btn_toggle_text') ? get_option('gt_tax_btn_toggle_text') : 'excl. tax';
        
            if(wc_tax_enabled() && $gt_btn_state == 'show'){
                if(is_shop() || is_product_category() || is_product() || is_front_page() || is_cart()) {
                    echo '<div class="sticky-slider tax-toggle-prices" id="gt-toggle-button" style = "background-color : '.esc_attr($gt_bg_color).'; color : '.esc_attr($gt_text_color).' ">
                            <span class="price-including-tax">'.esc_html($gt_tax_btn_text).'</span>
                            <span class="price-excluding-tax">'.esc_html($gt_tax_btn_toggle_text).'</span>
                        </div>';
                }    
            }

        }

        function gt_add_prices_data_attributes($price_html, $product) {
            $gt_tax_text = get_option('gt_tax_text') ? get_option('gt_tax_text') : 'TAX';
            
            // excluding tax price
            $excl_reg_price = wc_get_price_excluding_tax( $product, array(
                'price' => $product->regular_price
            ));
            $excl_sale_price = wc_get_price_excluding_tax($product);
            // including tax price
            $incl_reg_price = wc_get_price_including_tax( $product, array(
                'price' => $product->regular_price
            ));
            $incl_sale_price = wc_get_price_including_tax($product);
        
            if(wc_tax_enabled()){ 
                if($product->is_on_sale()){  
                    $price_html = '<div class="price-tax-incl">' . wc_format_sale_price(wc_get_price_to_display( $product, array( 'price' => $incl_reg_price ) ), 
                                                                    wc_get_price_to_display(  $product, array( 'price' => $incl_sale_price ) )) . '<small class="woocommerce-price-suffix"> incl. '.esc_html($gt_tax_text).' </small>' . '</div>
                                    <div class="price-tax-excl">' . wc_format_sale_price(wc_get_price_to_display( $product, array( 'price' => $excl_reg_price ) ), 
                                                                    wc_get_price_to_display(  $product, array( 'price' => $excl_sale_price ) )) . '<small class="woocommerce-price-suffix"> excl. '.esc_html($gt_tax_text).' </small>' . '</div>' ;
                }else{
                    $price_html = '<div class="price-tax-incl">' . wc_price( wc_get_price_to_display( $product, array( 'price' => $incl_reg_price ) )). '<small class="woocommerce-price-suffix"> incl. '.esc_html($gt_tax_text).' </small>' . '</div>
                                    <div class="price-tax-excl">' . wc_price( wc_get_price_to_display( $product, array( 'price' => $excl_reg_price ) )) . '<small class="woocommerce-price-suffix"> excl. '.esc_html($gt_tax_text).' </small>' . '</div>' ;
                }
            }
            return $price_html;
        }

        function gt_style_head(){
            $gt_txt_opt = get_option(" woocommerce_tax_display_shop ");
            $gt_btn_state = get_option('gt_tax_btn_state') ? get_option('gt_tax_btn_state') : 'show';
            if($gt_btn_state === 'show'){
            ?>
                <style>
                .price-tax-excl, .tax-toggle-prices .price-including-tax, .cart_totals  .tax-rate, .cart_totals  .order-total{
                    display: <?php if($gt_txt_opt == 'excl'){ echo 'block'; }else{ echo 'none'; } ?>;
                }
                .price-tax-incl, .tax-toggle-prices .price-excluding-tax, .cart_totals  .tax-rate, .cart_totals  .order-total{
                    display: <?php if($gt_txt_opt == 'excl'){ echo 'none'; }else{ echo 'block'; } ?>;
                }
                </style>
            <?php
            }
        }

    }

    $Gt_frontend = new Gt_frontend();        

}

?>