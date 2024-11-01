<?php
/**
 * Plugin name: Toggle Tax For Woocommerce
 * Description: The Toggle Tax plugin allows store owners to easily toggle tax display for their products in WooCommerce. This plugin allows customers to toggle between including and excluding tax prices of each product.
 * Version: 1.0.1
 * Author: mgplugin
 * Text Domain: toggle-tax-for-woocommerce
 */

if( ! defined ( 'ABSPATH' ) ){
    exit;
}

if( ! class_exists ('GtTaxToggle') ){

    class GtTaxToggle 
    {
        public function __construct()
        {
            $this->init();
            $this->include();
        } 

        function init(){
            add_action('wp_enqueue_scripts', array($this, 'gt_include_scripts'));
        }

        function include(){
            include_once('frontend/frontend.php');
            include_once('admin/backend.php');
        }

        function gt_include_scripts(){
            wp_enqueue_script('gt-custom-script', plugins_url('frontend/js/customscript.js', __FILE__), array('jquery'), null, true);
            wp_enqueue_style('gt-custom-style', plugins_url('frontend/css/customstyle.css', __FILE__), ' ', null);  
            wp_localize_script('gt-custom-script','ajax_url',array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'taxdisplay' => get_option(" woocommerce_tax_display_shop "),
            )); 
        }
        
    }

    $GtTaxToggle = new GtTaxToggle();  
    
}








