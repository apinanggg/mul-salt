<?php
/**
 **** AppzStory Basic Course1 ****
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.class.php';
require_once '../response.class.php';


if($_SERVER['REQUEST_METHOD'] === "GET") {
    
    $products = DB::query('SELECT * FROM products AS p LEFT JOIN categories AS c ON p.cat_id = c.cat_id');
   
    $categories = DB::query('SELECT * FROM categories');
 
    $response = array(
        'products' => $products,
        'categories' => $categories
    );
    
    return Response::success($response, 'success');
} else {
   
    return Response::error('Method Not Allowed!', 405);
}


