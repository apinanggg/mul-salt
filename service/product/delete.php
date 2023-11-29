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
if($_SERVER['REQUEST_METHOD'] === "DELETE") {
    /** ดึงข้อมูล Method DELETE มาใช้งาน */
    parse_str(file_get_contents("php://input"), $_DELETE);
    /** สร้างชุดข้อมูล Params Array Id */
    $params = array('p_id' => $_DELETE['id']);
    /** เรียกใช้งาน Method query สำหรับประมวลผลคำสั่ง SQL */
    $query = DB::query('DELETE FROM products WHERE p_id = :p_id', $params);
    if($query){
        /** เรียกใช้งาน Method success สำหรับ Response ข้อมูลกลับไป */
        return Response::success($query, 'Delete Success');
    }else{
        /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */
        return Response::error('Not found!');
    }
} else {
    /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */
    return Response::error('Method Not Allowed!', 405);
}
