<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey_fields.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/form_types.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/user.class.php";
class SurveyFrameGenerator
{
    // Frame URL oluşturma metodu
    public static function generateFrameSrc($survey_fields_id)
    {
        try {

            // Survey field bilgilerini al
            $survey_fields = Survey_fields::getSurveyFieldsById($survey_fields_id);
            if (!$survey_fields) {
                throw new Exception('Survey field not found', 404);
            }

            // Survey bilgilerini al
            $survey = Survey::getById($survey_fields["survey_id"]);
            if (!$survey) {
                throw new Exception('Survey not found', 404);
            }

            // Kullanıcı bilgilerini al
            $user = User::getUserById($survey["created_by"]);
            if (!$user) {
                throw new Exception('User not found', 404);
            }


            // Form türünü al
            $form_types = Form_types::get_form_type($survey_fields["type_id"]);
            if (!$form_types) {
                throw new Exception('Form type not found', 404);
            }

            // Frame src URL'sini oluştur
            $frame_src = $form_types["path_name"]
                . "?bg=" . urlencode($survey["backgroundColor"])
                . "&font=" . urlencode($survey["fontColor"])
                . "&title=" . urlencode($survey["title"])
                . "&desc=" . urlencode($survey["description"])
                . "&company=" . urlencode($user["company_name"])
                . "&field_title=" . urlencode($survey_fields["title"])
                ."&sf=" . urlencode($survey_fields_id);

            // Başarılı sonucu döndür
            return [
                'success' => true,
                'frame_src' => $frame_src
            ];
        } catch (Exception $e) {
            // Hataları uygun formatta döndür
            return [
                'error' => $e->getMessage(),
                'code' => $e->getCode() ?: 500
            ];
        }
    }
}
