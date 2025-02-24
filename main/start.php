<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/survey_fields.class.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/profiles.class.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/surveyFrameGenerator.php";


$name=$_POST["name"];

$surname=$_POST["surname"];

$email=$_POST["email"];

$profile=Profiles::create($name,$surname,$email);

$_SESSION["profile_id"]=$profile;
$hash_id=$_POST["hash_id"];

$survey_field_id=Survey::getFirstSurveyFieldId($hash_id);

$frame=SurveyFrameGenerator::generateFrameSrc($survey_field_id);
$frame_src=$frame["frame_src"];
header("Location: $frame_src");
