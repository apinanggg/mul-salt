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
require_once '../helper.class.php';

/** ตรวจสอบ REQUEST METHOD ตรงกับที่กำหนดหรือไม่ */
if($_SERVER['REQUEST_METHOD'] === "PUT") {
    /** ดึงข้อมูล Method PUT มาใช้งาน */
    parse_str(file_get_contents("php://input"), $_PUT);


    $cat_id =  substr($_PUT['cat_id'],10,-10);

   $new_id =  base64_decode($cat_id);

    /** สร้างชุดข้อมูล Array เพื่อเก็บเข้าฐานข้อมูล */
    $params = array(
        'cat_name' => Helper::clean($_PUT['cat_name']),
        'cat_title' => Helper::clean($_PUT['cat_title']),
        'updated_at' => date("Y-m-d h:i:s"),
        'cat_id' =>  $new_id
    );
    /** เรียกใช้งาน Method query สำหรับประมวลผลคำสั่ง SQL */
    $affected = DB::query("UPDATE categories SET 
                            cat_name = :cat_name,
                            cat_title = :cat_title,
                            updated_at = :updated_at
                            WHERE cat_id = :cat_id", $params);
    /** เรียกใช้งาน Method success สำหรับ Response ข้อมูลกลับไป */
    return Response::success($affected, 'แก้ไขข้อมูลเสร็จเรียบร้อย', 200);
} else {
    /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */ 
    return Response::error('Method Not Allowed!', 405);
}

