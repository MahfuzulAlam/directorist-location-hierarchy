<?php

/** 
 * @package  Directorist - Location Hierarchy
 */

/**
 * Plugin Name:       Directorist - Location Hierarchy
 * Plugin URI:        https://wpwax.com
 * Description:       This plugin will allow the location taxonomy to show in an arranged way
 * Version:           1.0.0
 * Requires at least: 5.2
 * Author:            wpWax
 * Author URI:        https://wpwax.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       directorist-location-hierarchy
 * Domain Path:       /languages
 */

/* This is an extension for Directorist plugin. This plugin will allow the location taxonomy to show in a arranged way. */

/**
 * If this file is called directly, abrot!!!
 */
if (!defined('ABSPATH')) {
    exit;                      // Exit if accessed
}

/**
 * Constants
 */
if (!defined('DIR_LOC_HIER_BASE_DIR')) {
    define('DIR_LOC_HIER_BASE_DIR', plugin_dir_path(__FILE__));
}

/**
 * Enable the Custom Field Meta Key
 */
add_filter('directorist_custom_field_meta_key_field_args', function ($args) {
    $args['type'] = 'text';
    return $args;
});

/**
 * GET TEMPLATES
 */
function dir_loc_hier_get_template($template_file, $args = array())
{
    if (is_array($args)) {
        extract($args);
    }

    $file = DIR_LOC_HIER_BASE_DIR . '/templates/' . $template_file . '.php';

    if (file_exists($file)) {
        include $file;
    }
}

/**
 * Search listing templates
 */

add_filter('directorist_search_field_template', 'override_search_widgets_template_category_field', 10, 2);

function override_search_widgets_template_category_field($template, $field_data)
{
    $data['data'] = $field_data;
    /*
    if ('search-form/fields/category' == $template) {
        $template = dir_loc_hier_get_template($template, $data);
    }
    */
    if ('search-form/fields/location' == $template) {
        $template = dir_loc_hier_get_template($template, $data);
    }

    return $template;
}

/**
 * JS SNIPPET
 */
/*
add_action('wp_footer', function () {
?>
    <script type="text/javascript">
        jQuery(document).ready(($) => {
            // Assuming you have a Select2 element with an ID of "mySelect2"

            $('select[name="in_cat_parent"]').on('change', function() {

                var parent_value = $(this).val();

                var category_children = $('#category_children').val();

                if (category_children) {
                    category_children = JSON.parse(category_children)
                    category_children = category_children[parent_value]
                }

                // Get a reference to the Select2 element
                var select2Element = $('select[name="in_cat"]');

                // Clear existing options from the Select2 element
                select2Element.empty();

                // Create new options
                var newOptions = []
                if (category_children) {
                    category_children.forEach(child => {
                        newOptions.push({
                            id: child.term_id,
                            text: child.name
                        })
                    });
                }

                // Add the new options to the Select2 element
                select2Element.select2({
                    data: newOptions
                });


            });

            $('select[name="in_cat_parent"]').on('change', function(e) {
                e.preventDefault();
            });
        })
    </script>
<?php
});
*/

/**
 * JS SNIPPET LOCATION
 */

add_action('wp_footer', function () {
?>
    <script type="text/javascript">
        jQuery(document).ready(($) => {
            // Assuming you have a Select2 element with an ID of "mySelect2"

            $('select[name="in_country"]').on('change', function() {

                var parent_value = $(this).val();

                var location_children = $('#location_children').val();


                if (location_children) {
                    location_children = JSON.parse(location_children)
                    location_children = location_children[parent_value]
                }

                // Get a reference to the Select2 element
                var select2Element = $('select[name="in_state"]');
                var cityElement = $('select[name="in_city"]');

                // Clear existing options from the Select2 element
                select2Element.empty();
                cityElement.empty();

                // Create new options
                var newOptions = []
                newOptions.push({
                    id: 0,
                    text: 'State'
                })
                if (location_children) {
                    location_children.forEach(child => {
                        newOptions.push({
                            id: child.term_id,
                            text: child.name
                        })
                    });
                }

                // Add the new options to the Select2 element
                select2Element.select2({
                    data: newOptions
                });

                // Set Current Value
                $('input[name="in_loc"]').val($(this).val());
            });

            // $('select[nasme="in_country"]').on('change', function(e) {
            //     e.preventDefault();
            // });

            $('select[name="in_state"]').on('change', function() {

                var parent_value = $(this).val();

                var location_children = $('#location_city').val();


                if (location_children) {
                    location_children = JSON.parse(location_children)
                    location_children = location_children[parent_value]
                }

                // Get a reference to the Select2 element
                var select2Element = $('select[name="in_city"]');

                // Clear existing options from the Select2 element
                select2Element.empty();

                // Create new options
                var newOptions = []
                newOptions.push({
                    id: 0,
                    text: 'City'
                })
                if (location_children) {
                    location_children.forEach(child => {
                        newOptions.push({
                            id: child.term_id,
                            text: child.name
                        })
                    });
                }

                // Add the new options to the Select2 element
                select2Element.select2({
                    data: newOptions
                });

                // Set Current Value
                $('input[name="in_loc"]').val($(this).val());
            });

            $('select[name="in_city"]').on('change', function() {
                // Set Current Value
                $('input[name="in_loc"]').val($(this).val());
            });
        })
    </script>
<?php
});
