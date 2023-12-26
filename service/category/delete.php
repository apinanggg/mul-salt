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
    /** สร้างชุดข้อมูล Array Id */


   $cat_id =  substr($_DELETE['cat_id'],10,-10);

   $new_id =  base64_decode($cat_id);

    $params = array('cat_id' => $new_id);
    /** เรียกใช้งาน Method query สำหรับประมวลผลคำสั่ง SQL */
    $query = DB::query('DELETE FROM categories WHERE cat_id = :cat_id', $params);
    if($query){
        /** เรียกใช้งาน Method success สำหรับ Response ข้อมูลกลับไป */
        return Response::success($query, 'รายการของคุณถูกลบเรียบร้อย');
    }else{
        /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */
        return Response::error('ไม่พบรายการ', 404);
    }
} else {
    /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */ 
    return Response::error('Method Not Allowed!', 405);
}
