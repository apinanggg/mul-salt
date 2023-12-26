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
   
    $categories = DB::query('SELECT * FROM categories');
    //print_r($categories); 
    $response = array();

    foreach ($categories as $Index => $value){
        $rand = generateRandomString();
        $rand2 = generateRandomString();
        $response[$Index]['cat_id'] = $rand.base64_encode($value['cat_id']).$rand2;
        $response[$Index]['cat_title'] = ($value['cat_title']); 
        $response[$Index]['cat_name']= ($value['cat_name']);
        $response[$Index]['updated_at']= ($value['updated_at']);         
 
    }
   
    return Response::success($response , 'success');
// print_r($response);

   // return Response::success($response , 'success');
} else {
    
    return Response::error('Method Not Allowed!', 405);
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}


