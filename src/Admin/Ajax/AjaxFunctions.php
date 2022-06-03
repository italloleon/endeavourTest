<?php

namespace ImportApiPlugin\Admin\Ajax;

/**
 * Class to manage the plugin activation functions by ajax
 * 
 * @package    ImportApiPlugin
 * @subpackage ImportApiPlugin/src/Admin/Ajax
 * @author     Itallo Leonardo <itallolaraujo@gmail.com>
 * @since      1.0.0
 * 
 */
class AjaxFunctions
{

    /**
     * Import the received breweries from json
     *
     * @return void
     */
    public static function import_breweries_from_json()
    {
        $data = $_REQUEST['dataJson'];
        $resultsArray = array();
        for ($count = 1; $count <= 3; $count++) {
            $requestResult = self::curlApiBrewery($count);
            $requesJsonDecode = json_decode($requestResult);
            $resultsArray = array_merge($resultsArray, $requesJsonDecode);
        }
        $dataToJson = $resultsArray;
        $created_breweries_array = array();
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
                'brewery_cat' => $catAdded,
                'brewery_edit_url' => get_edit_post_link($new_brewery, false)
            ));
        }
        self::update_imported_breweries_option();
        echo json_encode($created_breweries_array);
        die();
    }

    /**
     * Gets data from brewery API
     *
     * @return void
     */
    public static function curlApiBrewery($page = 1)
    {
        $url = 'https://api.openbrewerydb.org/breweries?';
        $query = "page=$page&per_page=25";
        $request_url = $url . $query;
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * Create a post meta array to the new post
     *
     * @return array post meta array.
     */
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

    /**
     * Sets a new category to new post
     *
     * @return int created post id.
     */
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

    /**
     * Update the api_breweries_imported options
     *
     * @return void
     */
    public static function update_imported_breweries_option()
    {
        update_option('api_breweries_imported', 1);
    }
}
