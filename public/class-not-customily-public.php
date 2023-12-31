<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://daudau.cc
 * @since      1.0.0
 *
 * @package    Not_Customily
 * @subpackage Not_Customily/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Not_Customily
 * @subpackage Not_Customily/public
 * @author     Nguyen Viet <bangnokia@gmail.com>
 */
class Not_Customily_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles()
    {
//        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/not-customily-public.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts()
    {
//        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/not-customily-public.js', array('jquery'), $this->version, false);
    }

    public function add_personalized_section()
    {
        if (is_product()) {
            $this->injectPersonalize();
        }
    }

    protected function injectPersonalize()
    {
        global  $product;

        $warehouse_product_id = $_GET['warehouse_product_id'] ?? get_post_meta($product->get_id(), 'warehouse_product_id', true);

        if ($warehouse_product_id) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-remote', 'https://customedge-injector.pages.dev/style.css', array(), $this->version, 'all');
            wp_enqueue_script($this->plugin_name, 'https://customedge-injector.pages.dev/wp-customedge.iife.js', [], $this->version, true);
            echo <<<HTML
                <div id="tda-customedge" class="tda-peronalized-section">Loading personalization...</div>
                <script type="text/javascript">
                if (window.customily === undefined) {
                    window.customily = {
                        target: '#tda-customedge',
                        productId: $warehouse_product_id,
                        previewWrapper: document.querySelector('.product-gallery'),
                        formWrapper: document.querySelector('.product-info form.cart'),
                        wooProductId: {$product->get_id()},
                    }
                }
                </script>
HTML;
        }
    }
}
