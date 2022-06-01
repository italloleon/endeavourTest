<?php

namespace ImportApiPlugin\Admin\Ajax;


/**
 * Class to manage the plugin activation functions
 * 
 * @package    ImportApiPlugin
 * @subpackage ImportApiPlugin/src/Admin/Ajax
 * @author     Itallo Leonardo <itallolaraujo@gmail.com>
 * @since      1.0.0
 * 
 */
class AjaxFunctions
{

    public static function import_breweries_from_json()
    {
        $data = $_REQUEST['dataJson'];
        $dataToJson = json_decode(stripslashes($data));
        $created_breweries_array = array();
        // var_dump($dataToJson);
        foreach ($dataToJson as $breweryElement) {
            $new_brewery_data = array(
                'post_title'    => $breweryElement->name,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => 'brewery',
                'meta_input'    => self::plugin_create_post_meta($breweryElement)
            );
            $new_brewery = wp_insert_post($new_brewery_data);
            $catAdded = self::plugin_set_element_category($new_brewery, $breweryElement->brewery_type);
            array_push($created_breweries_array, array(
                'brewery_name' => $breweryElement->name,
                'brewery_id' => $new_brewery,
                'brewery_wp_url' => get_permalink($new_brewery),
                'brewery_cat' => $catAdded
            ));
        }
        self::update_imported_breweries_option();
        echo json_encode($created_breweries_array);
        die();
    }

    public static function plugin_create_post_meta($element)
    {
        $post_meta_array = array(
            'name' => $element->name,
            'city' => $element->city,
            'country' => $element->country,
            'phone' => $element->phone,
            'website_url' => $element->website_url,
            'postal_code' => $element->postal_code,
        );
        return $post_meta_array;
    }

    public static function plugin_set_element_category($elementToInsert, $currentCategory)
    {
        if (category_exists($currentCategory)) {
            $catId = get_term_by('name', $currentCategory, 'category')->term_id;
            wp_set_post_categories($elementToInsert, $catId);
            return $catId;
        }
        $newCatId = wp_create_category($currentCategory);
        wp_set_post_categories($elementToInsert, $newCatId);
        return $newCatId;
    }
    public static function update_imported_breweries_option()
    {
        update_option('api_breweries_imported', 1);
    }
}
