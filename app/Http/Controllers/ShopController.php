<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Collection;

class ShopController extends Controller
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

            $order_line_items_size = sizeof($order_data['line_items']);
            $order_line_items = $order_data['line_items'][0];
            
            if ( array_key_exists($order_line_items['product_id'],$temp_product_array) ) {
                echo 'found ' . $key . ' , ';

            } else {
                array_push($temp_product_array, [

                    $order_line_items['product_id'] => [
    
                        'product_name'          => $order_line_items['name'],
                        // 'product_quantity'      => (sizeof($products[$key]['variants']) > 1 ? ($products[$key]['variants'][$key]['inventory_quantity'] + $products[$key]['variants'][$key+1]['inventory_quantity']) : $products[$key]['variants'][0]['inventory_quantity']),
                        'vendor'                => $products[$key]['vendor'],
                        'product_type'          => $products[$key]['product_type'],
                        'tags'                  => $order_data['tags'],
                        'status'                => $products[$key]['status'],
                        //'inventory_price'       => ,
                        'orders'    => [
                            $order_data['id'] => [
                                'created_at'    => $order_data['created_at'],
                                'cancelled_at'  => $order_data['cancelled_at'],
                                'total_price'   => $order_data['total_price'],
                            ],
                            'customer_data'   => [
                                $key    => [
                                    'customer_id'   => $order_data['customer']['id'],
                                    'email'         => $order_data['customer']['email'],
                                    'customer_name' => $order_data['customer']['first_name'] . $order_data['customer']['last_name'],
                                ],
                            ],
                            'line_items'     => [
                                $key => [
                                    'name'      => $order_line_items['id'],
                                ],
                            ],
                        ],
    
                    ],
                ]);
                // $total_product_quantity += $order_line_items['quantity'];
            }
            
        }

        echo '<pre>';
        //print_r($send_product_customer_array);
        //print_r($temp_product_array);
        dd($temp_product_array);
        //dd($products);
        dd($orders);
        die();
        
        return view('product_order', ["products" => $product_data, "total_product_buy" => $total_product_quantity]); 
    }
}
