<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/qrCodeGenerator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/survey.class.php";


$g = qrCodeGenerator::generate($qrhash_id);
?>

<img src="/uploads/qrs/<?= $g ?>.png?t=<?= time() ?>" style="width: <?= $qr_width ?>;height: <?= $qr_height?>">
