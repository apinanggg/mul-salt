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
    /** เก็บข้อมูลไฟล์ภาพเดิม */
    $p_image = $_POST['p_image'];
    /** ตรวจสอบว่ามีการอัปโหลดไฟล์ภาพมาหรือไม่ */
    if(isset($_FILES['file']['tmp_name'])){
        /** เข้าถึงนามสกุลไฟล์ของรูปภาพ */
        $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
         /** นามสกุลรูปภาพที่อนุญาตให้ใช้งานได้ */
        $supported = array('jpg', 'jpeg', 'png', 'gif');
        /** เช็คนามสกุลรูปภาพว่าตรงตามที่กำหนดไว้หรือไม่ */
        if( in_array($extension, $supported) && Helper::isMimeValid($_FILES['file']['tmp_name']) ){
            /** สร้างชื่อรูปภาพขึ้นมาใหม่ */
            $p_image = md5(microtime()).'.'.$extension;
            /** สร้างเส้นทางเพื่อเก็บไฟล์รูปภาพ */
            $pathUpload = '../../assets/uploads/' . $p_image;
            /** ทำการย้ายรูปภาพเข้าสู่โฟลเดอร์ */
            if(!move_uploaded_file($_FILES['file']['tmp_name'], $pathUpload)){
                /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */ 
                return Response::error('ไม่สามารถอัพโหลดไฟล์ใหม่ได้', 400);
            }
        }
    }
    /** สร้างชุดข้อมูล Array เพื่อเก็บเข้าฐานข้อมูล */
    $params = array(
        'p_name' => Helper::clean($_POST['p_name']),
        'p_title' => Helper::clean($_POST['p_title']),
        'p_price' => Helper::clean($_POST['p_price']),
        'p_image' => $p_image,
        'p_detail' => Helper::clean($_POST['p_detail']),
        'p_status' => isset($_POST['p_status']) ? 'true' : 'false',
        'cat_id' => Helper::clean($_POST['cat_id']),
        'updated_at' => date("Y-m-d h:i:s"),
        'p_id' => Helper::clean($_POST['p_id'])
    );
    /** เรียกใช้งาน Method query สำหรับประมวลผลคำสั่ง SQL */
    $affected = DB::query("UPDATE products SET 
                        p_name = :p_name,
                        p_title = :p_title, 
                        p_price = :p_price,
                        p_image = :p_image, 
                        p_detail = :p_detail,
                        p_status = :p_status,
                        cat_id = :cat_id, 
                        updated_at = :updated_at
                        WHERE p_id = :p_id", $params);
    /** เรียกใช้งาน Method success สำหรับ Response ข้อมูลกลับไป */                    
    return Response::success($affected, 'แก้ไขข้อมูลเสร็จเรียบร้อย', 200);
} else {
    /** เรียกใช้งาน Method error สำหรับ Response ข้อมูลกลับไป */ 
    return Response::error('Method Not Allowed!', 405);
}
