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
if($_SERVER['REQUEST_METHOD'] === "POST") {
    /** สร้างชุดข้อมูล Array เพื่อเก็บเข้าฐานข้อมูล */
    $params = array(
        'cat_name' => Helper::clean($_POST['cat_name']),
        'cat_title' => Helper::clean($_POST['cat_title']),
        'created_at' => date("Y-m-d h:i:s"),
        'updated_at' => date("Y-m-d h:i:s")
    );
    /** เรียกใช้งาน Method query สำหรับประมวลผลคำสั่ง SQL */
    $affected = DB::query("INSERT INTO categories (cat_name, cat_title, created_at, updated_at) 
                            VALUES (:cat_name, :cat_title, :created_at, :updated_at)", $params);
    /** เรียกใช้งาน Method success สำหรับ Response ข้อมูลกลับไป */
    return Response::success($affected, 'บันทึกข้อมูลเสร็จเรียบร้อย', 201);
} else {
    /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */ 
    return Response::error('Method Not Allowed!', 405);
}
