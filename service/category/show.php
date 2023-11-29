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

/** ตรวจสอบ REQUEST METHOD ตรงกับที่กำหนดหรือไม่ */
if($_SERVER['REQUEST_METHOD'] === "GET") {
    /** สร้างชุดข้อมูล Params Array Id */
    $params = array('cat_id' => $_GET['id']);
    /** เรียกใช้งาน Method query สำหรับประมวลผลคำสั่ง SQL */
    $category = DB::query('SELECT * FROM categories WHERE cat_id = :cat_id', $params);
    if(count($category)){
        /** เรียกใช้งาน Method success สำหรับ Response ข้อมูลกลับไป */
        return Response::success($category[0], 'success');
    } else {
        /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */
        return Response::error('ไม่มีข้อมูล', 404);
    }
} else {
    /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */
    return Response::error('Method Not Allowed!', 405);
}
