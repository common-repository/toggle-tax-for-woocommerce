<?php

if( ! defined ( 'ABSPATH' ) ){
    exit;
}

if( ! class_exists ('Gt_backend') ){

    class Gt_backend {

        public function __construct()
        {
            add_filter( 'woocommerce_settings_tabs_array', array($this, 'gt_add_settings_tab'), 50 );
            add_action( 'woocommerce_settings_tax_toggle', array($this, 'gt_woo_settings_page') );
            add_action( 'woocommerce_update_options_tax_toggle', array($this, 'gt_save_custom_settings_fields') );
        }   

        function gt_add_settings_tab($tabs) {
            if(wc_tax_enabled()){
                $tabs['tax_toggle'] = __('Toggle Tax','toggle-tax-for-woocommerce');
            }
            return $tabs;
        }
        
        function gt_woo_settings_page() {
            woocommerce_admin_fields( self::gt_custom_settings_fields() );
        }
        
        function gt_custom_settings_fields() {

            $settings = array();
                // custom fields
            $settings = array(
                    // Title
                    array(
                        'title'     => __( 'Toggle tax Settings', 'toggle-tax-for-woocommerce' ),
                        'type'      => 'title',
                        'id'        => 'gt_toggle_tax_settings'
                    ),
                    // Select
                    array(
                        'title'     => __( 'Select Button State', 'toggle-tax-for-woocommerce' ),
                        'desc'      => __( 'Select an option to hide or show the toggle button at frontend side', 'toggle-tax-for-woocommerce' ),
                        'id'        => 'gt_tax_btn_state',
                        'class'     => 'wc-enhanced-select',
                        'default'   => 'show',
                        'type'      => 'select',
                        'options'   => array(
                            'hide'        => __( 'Hide', 'toggle-tax-for-woocommerce' ),
                            'show'        => __( 'Show', 'toggle-tax-for-woocommerce' ),
                        ),  
                        'desc_tip' => true,
                    ),
                     // text
                     array(
                        'title'     => __( 'Add tax text', 'toggle-tax-for-woocommerce' ),
                        'type'      => 'text',
                        'desc'      => __( 'Enter the Tax text that you want to display after price e.g. TAX, VAT etc..', 'toggle-tax-for-woocommerce' ),
                        'desc_tip'  => true,
                        'default'   => 'TAX',
                        'id'        => 'gt_tax_text',
                    ),
                    // text
                    array(
                        'title'     => __( 'Add Button text', 'toggle-tax-for-woocommerce' ),
                        'type'      => 'text',
                        'desc'      => __( 'Enter the button text that you want to show.', 'toggle-tax-for-woocommerce' ),
                        'desc_tip'  => true,
                        'default'   => 'Incl. tax',
                        'id'        => 'gt_tax_btn_text',
                    ),
                    // text
                    array(
                        'title'     => __( 'Add Button Toggle text', 'toggle-tax-for-woocommerce' ),
                        'type'      => 'text',
                        'desc'      => __( 'Enter the toggle button text that you want to toggle with button.', 'toggle-tax-for-woocommerce' ),
                        'desc_tip'  => true,
                        'default'   => 'Excl. tax',
                        'id'        => 'gt_tax_btn_toggle_text',
                    ),
                    // bg color
                    array(
                        'title'     => __( 'Add Background Color', 'toggle-tax-for-woocommerce' ),
                        'type'      => 'color',
                        'desc'      => __( 'Enter the color that you want to show as background of button.', 'toggle-tax-for-woocommerce' ),
                        'desc_tip'  => true,
                        'default'   => '#333333',
                        'id'        => 'gt_tax_bg_color',
                    ),
                    // text color
                    array(
                        'title'     => __( 'Add Text Color', 'toggle-tax-for-woocommerce' ),
                        'type'      => 'color',
                        'desc'      => __( 'Enter the color that you want to show as text of button.', 'toggle-tax-for-woocommerce' ),
                        'desc_tip'  => true,
                        'default'   => '#ffffff',
                        'id'        => 'gt_tax_text_color',
                    ),
                    array(
                        'type'      => 'sectionend',
                        'id'        => 'toggle_tax_settings_end'
                    ),
                );
            
            return $settings;
        }

        function gt_save_custom_settings_fields() {
            woocommerce_update_options( self::gt_custom_settings_fields() );
        }
    
    }    
    
    $Gt_backend = new Gt_backend();   
    
}
