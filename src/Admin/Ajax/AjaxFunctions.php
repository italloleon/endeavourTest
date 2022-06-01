<?php

namespace ImportApiPlugin\Admin\Ajax;

use stdClass;

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
                'meta_input'    => self::create_post_meta($breweryElement)
            );
            $new_brewery = wp_insert_post($new_brewery_data);
            array_push($created_breweries_array, array(
                'brewery_name' => $breweryElement->name,
                'brewery_id' => $new_brewery,
                'brewery_wp_url' => get_permalink($new_brewery)
            ));
        }
        echo json_encode($created_breweries_array);
        die();
    }

    public static function create_post_meta($element)
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
}
