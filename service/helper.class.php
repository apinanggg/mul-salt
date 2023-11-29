<?php 
/**
 **** AppzStory Basic1 PHP Ajax Basic Report ****
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 * 
 */
class Helper {
    /** Method สำหรับการเช็ครูปภาพ Mime Image */
    public static function isMimeValid($tmp_name){
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mtype = finfo_file( $finfo, $tmp_name );
        if(strpos($mtype, 'image/') !== false){
            return true;
        }
        finfo_close( $finfo );
        return false;
    }

    /** clean */
    public static function clean($input){
        /** เปลี่ยน predefined characters เป็น HTML entities ด้วยฟังก์ชัน htmlspecialchars() */
        $data = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $data;
    }

}
