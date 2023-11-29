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
if($_SERVER['REQUEST_METHOD'] === "POST") {
    /** สร้างชุดข้อมูล Array เพื่อเก็บเข้าฐานข้อมูล */
    $params = array(
        'p_status' => $_POST['value'], 
        'p_id' => (INT)$_POST['id']
    );
    /** เรียกใช้งาน Method query สำหรับประมวลผลคำสั่ง SQL */
    $affected = DB::query('UPDATE products SET p_status = :p_status WHERE p_id = :p_id ', $params);
    if($affected){
        /** เรียกใช้งาน Method success สำหรับ Response ข้อมูลกลับไป */
        return Response::success($_POST['value'], 'แก้ไขข้อมูลเสร็จเรียบร้อย', 200);
    } else {
        /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */
        return Response::error('มีปัญหาในการแก้ไขข้อมูล', 400);
    }
} else {
    /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */
    return Response::error('Method Not Allowed!', 405);
}
