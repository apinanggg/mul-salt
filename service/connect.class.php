<?php
/**
 **** AppzStory Basic1 PHP Ajax Basic Report ****
 *
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 *
 */
session_start();
error_reporting(E_ALL);
date_default_timezone_set('Asia/Bangkok');

/** Class Database สำหรับติดต่อฐานข้อมูล */
class DB
{
    private static $DB_HOST = 'localhost'; /** กำหนด Property $DB_HOST */
    private static $DB_USERNAME = 'root'; /** กำหนด Property $DB_USERNAME */
    private static $DB_PASSWORD = ''; /** กำหนด Property $DB_PASSWORD */
    private static $DB_DATABASE = 'basic1_crud'; /** กำหนด Property $DB_DATABASE */

    private static $connect = null; /** กำหนด Property $connect */
    private static $response = true; /** กำหนด Property $response มีค่าเริ่มต้นเป็น true */

    public static function connect()
    {
        try {
            self::$connect = new PDO(
                'mysql:host='.self::$DB_HOST.'; 
                                    dbname='.self::$DB_DATABASE.'; 
                                    charset=utf8',
                self::$DB_USERNAME,
                self::$DB_PASSWORD
            );
            self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$connect;
        } catch (PDOException $e) {
            echo "การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $e->getMessage();
            exit();
        }
    }

    public static function query($query = null, $params = array())
    {
        if (self::$connect instanceof PDO) {
            try {
                /** คำสั่ง Query SQL */
                $statement = self::$connect->prepare($query);
                /** ประมวณผลคำสั่ง */
                $statement->execute($params);
                $command = strtoupper(explode(' ', $query)[0]);
    
                /** ถ้าคำสั่ง SQL เป็น SELECT จะ return ข้อมูลแบบ Associative ออกไป */
                if ($command === 'SELECT') {
                    self::$response = $statement->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    /** ถ้าคำสั่ง SQL เป็นอื่น จะ return ข้อมูลจำนวน row ที่ทำสำเสร็จออกไป */
                    self::$response = $statement->rowCount();
                }
                return self::$response;
            } catch (Throwable $e) {
                http_response_code(500);
                echo "การประมวลผลข้อมูลล้มเหลว: " . $e->getMessage();
                exit();
            }
        } else {
            http_response_code(500);
            echo "โปรดเปิดการเชื่อมต่อฐานข้อมูล";
            exit();
        }
    }
}
/**
 * ประกาศ Instance ของ Class Database
 */
DB::connect();
/** กำหนด timezone */
date_default_timezone_set('Asia/Bangkok');
