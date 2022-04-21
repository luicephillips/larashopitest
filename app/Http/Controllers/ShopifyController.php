<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopifyController extends Controller
{
    public function index() {
        $shop = Auth::user();

        // All Products data from Shopify Products API
        $products = $shop->api()->rest('GET', '/admin/api/2022-04/products.json');
        $products = $products['body']['container']['products'];

        // All Orders data from Shopify Orders API
        $orders = $shop->api()->rest('GET', '/admin/api/2022-04/orders.json');
        $orders = $orders['body']['container']['orders'];

        // Initializing array variables
        $product_data = [];
        $temp_product_array = [];

        //$product_quantity = 0;
        $total_product_quantity = 0;

        // Creating a temporary array for storing product_id, quantity & customer_id from orders array.
        foreach ($orders as $key => $order_data) {
            array_push($temp_product_array, [
                'product_id' => $order_data['line_items'][0]['product_id'],
                'product_quantity' => $order_data['line_items'][0]['quantity'],
                'customer_id' => $order_data['customer']['id'],
            ]);
            $total_product_quantity += $order_data['line_items'][0]['quantity'];
        }
        
        // Creating a new array with product data from products array and matching customer and order data from orders array.
        foreach ($products as $product) {
            for ($i=0; $i < sizeof($orders) ; $i++) {
                array_reverse($orders);
                //$get_orders_product_id = $orders[$i]['line_items'][0]['product_id'];
                $product_quantity = $orders[$i]['line_items'][0]['quantity'];
                if( $orders[$i]['line_items'][0]['product_id'] == $product['id'] && $product['product_type'] ) {
                    array_push($product_data, [
                        'id'                => $product['id'],
                        'title'             => $product['title'],
                        'product_type'      => $product['product_type'],
                        'vendor'            => $product['vendor'],
                        'image'             => $product['images'][0]['src'],
                        'product_quantity'  => $product_quantity,
                        'order_id'          => $orders[$i]['id'],
                        'customer_data'     => [
                            'customer_id'       => $orders[$i]['customer']['id'],
                            'customer_name'     => $orders[$i]['customer']['first_name'] . ' ' . $orders[$i]['customer']['last_name'],
                            'orders_count'      => $orders[$i]['customer']['orders_count'],
                        ],
                    ]);
                }
            }
        }

        // Finalizing for sending data to products.blade.php
        // $counter = 0;
        // $send_product_customer_array = [];
        // foreach ($product_data as $key => $data) {

        //     while ($counter < sizeof($product_data)) {
                
        //         if( $temp_product_array[$counter]['product_id'] == $data['id'] && $temp_product_array[$counter]['customer_id'] == $data['customer_data']['customer_id'] ) {
        //             $set_new_product_quantity = $data['product_quantity'] + $temp_product_array[$counter]['product_quantity'];

        //             if (isset($product_data[$key]['product_quantity'])) {
        //                 $product_data[$key]['product_quantity'] = $set_new_product_quantity;
        //             }
        //             unset($temp_product_array[$counter]); // clearing the temp_array
        //         } else {
        //             if (isset($product_data[$key+1]['product_quantity'])) {
        //                 $product_data[$key+1]['product_quantity'] = $temp_product_array[$counter]['product_quantity'];
        //             }
        //         }
        //         $counter++;
        //     }

        // }
        
        //echo $total_product_quantity;
        echo '<pre>';
        //print_r($send_product_customer_array);
        //print_r($temp_product_array);
        //dd($products);
        dd($orders);
        die();



        return view('products', ["products" => $product_data, "total_product_buy" => $total_product_quantity]); 
    }
}
