<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/services/phpqrcode/qrlib.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/classes/survey.class.php';

class qrCodeGenerator
{
    public static function generate($hash_id){
        $save_dir=$_SERVER["DOCUMENT_ROOT"]."/uploads/qrs/";
        $size = 10; // Pixel size of each block
        $margin = 2; // Margin around the QR code
        $data="https://quicksurvey.store/survey?h=".$hash_id;
        $survey=Survey::getByHashId($hash_id);
        $survey_id=$survey["id"];
        $fileName=$save_dir.$survey_id.".png";
        QRcode::png($data, $fileName, QR_ECLEVEL_L, $size, $margin);
        return $survey_id;
    }
}