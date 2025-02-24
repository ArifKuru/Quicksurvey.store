<?php

$pageTitle="Customize | QuickSurvey";

?>
<html lang="en">
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/partials/dependencies.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/survey.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/classes/user.class.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/partials/auth_verify.php";

$survey=Survey::getByHashId($_GET["h"]);
$user=User::getUserById($_SESSION["user_id"]);
?>



<?php require_once $_SERVER["DOCUMENT_ROOT"]."/partials/navbar.php"?>


<body style="overflow: hidden">
<button
        onclick="publishSurvey(<?= $survey["id"]?>)"
        style="position: absolute;bottom: 35px;right: 35px;z-index: 1000;border-radius: 50%;height: 50px;width: 50px" class="btn btn-success hint--top" aria-label="Publish Your Survey"><i class="fa-solid fa-check"></i></button>

<div class="container-fluid">
<div
class="row mt-4">
    <div class="col-2" style="border-right: 1px solid gray;min-height: 80vh">
        <div style="height: 40vh; overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;" >

            <div class="mt-2 d-flex justify-content-between mb-2" style="align-items: center">
                <strong>Survey Outline!</strong>
                <button id="addQuestionButton" class="btn btn-success hint--top btn-sm" style="width: 25%" aria-label="Add New Question">+</button>
            </div>
            <div id="questionsOutlineDiv"></div>
        </div>

        <hr class="mb-2 mt-2">

        <div style="height: 40vh; overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">
         <strong class="mb-2 mt-2">Choose Form Type!</strong>
        <?php
         $sql = "SELECT * FROM form_types";
         $stmt = $pdo->prepare($sql);
         $stmt->execute();
         $formTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
         foreach ($formTypes as $formType) :?>
        <button class="btn btn-primary mt-2 w-100" onclick="updateSurveyFields({ id:getActiveSurveyFieldId(), form_type: <?= $formType["id"] ?> })"><?= $formType['name']?></button>
         <?php endforeach;?>
        </div>
    </div>

    <div class="col" style="padding-right: 15px">
        <div id="survey_general_container"
             style="background-color: <?= $survey["backgroundColor"] ?>; color: <?= $survey["fontColor"] ?>; width: 100%; height: 100%; position: relative;">

            <!-- Color Pickers -->
            <div style="position: absolute; top: 15px; left: 15px; display: flex; gap: 10px; align-items: center;">

                <!-- Background Color Picker -->
                <div class="d-flex align-items-center justify-content-center"
                     style="background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; gap: 10px; padding: 5px;">
                    <i class="fas fa-paint-brush" style="font-size: 24px; color: #333;"></i>
                    <input type="color" id="backgroundColorPicker" value="#563d7c"
                           title="Choose your background color"
                           style="border: none; cursor: pointer; width: 30px; height: 30px;">
                </div>

                <!-- Font Color Picker -->
                <div class="d-flex align-items-center justify-content-center"
                     style="background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; gap: 10px; padding: 5px;">
                    <i class="fas fa-font" style="font-size: 24px; color: #333;"></i>
                    <input type="color" id="fontColorPicker" value="#563d7c"
                           title="Choose your font color"
                           style="border: none; cursor: pointer; width: 30px; height: 30px;">
                </div>
                <div class="hint--bottom" aria-label="Write down your Question!" id="askQuestionButton"
                     style="width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <i class="fa-solid fa-question" style="color: darkgreen; font-size: 20px;"></i>
                </div>

            </div>

            <div style="width: 100%; height: 100%;">
                <iframe style="width: 100%; height: 100%; border: none;" id="surveyFrame"
>
                </iframe>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="sourceModal" tabindex="-1" aria-labelledby="sourceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sourceModalLabel">Share Your Survey!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid d-flex justify-content-center">
                <?php
                $qrhash_id=$survey["hash_id"];
                $qr_width="350px";
                $qr_height="350px";
                require_once $_SERVER["DOCUMENT_ROOT"]."/api/qr_img.php";
                ?>
                </div>
                <input type="text" class="form-control" value="https://quicksurvey.store/survey?h=<?= $_GET["h"] ?>"
                       id="hyperlinkInput" readonly onclick="copyToClipboard(this)">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="toast" id="copyToast" style="position: fixed; bottom: 20px; right: 20px;z-index: 1001">
    <div class="toast-body">
        Link copied to clipboard!
    </div>
</div>
<script>
    async function copyToClipboard(inputElement) {
        try {
            // Panoya input değerini yaz
            await navigator.clipboard.writeText(inputElement.value);

            // Toast mesajını göster
            const toast = new bootstrap.Toast(document.getElementById('copyToast'));
            toast.show();
        } catch (error) {
            console.error('Failed to copy: ', error);
            alert('Failed to copy the link. Please try again.');
        }
    }

    async function publishSurvey(surveyId) {
        // Endpoint URL
        const endpoint = '/api/publish.php';

        try {
            // POST isteği gönder
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: surveyId }) // Survey ID'yi gönder
            });

            // Yanıtı JSON formatında al
            const result = await response.json();
            const sourceModal = new bootstrap.Modal(document.getElementById('sourceModal'));

            if (response.ok && result.success) {
                // Başarılı durum
                sourceModal.show();
            } else {
                // Başarısız durum
                alert(`Failed to publish survey: ${result.message}`);
            }
        } catch (error) {
            // Ağ veya diğer hatalar
            console.error('An error occurred:', error);
            alert('An error occurred while publishing the survey. Please try again.');
        }
    }

    function updateSurvey(data) {
        // PUT isteği gönder
        fetch('/api/update_survey.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // Veriyi JSON olarak gönder
        })
            .then(response => response.json()) // JSON yanıtını çöz
            .then(result => {
                if (result.success) {
                    // Başarılı durum
                    loadFrame();
                } else {
                    // Hatalı durum
                    alert(result.message || 'An error occurred while updating.');
                }
            })
            .catch(error => {
                // Sunucuya bağlanılamadıysa hata mesajı göster
                console.error('Error updating survey:', error);
                alert('Failed to update survey field. Please try again.');
            });
    }

    function updateSurveyFields(data) {
        // PUT isteği gönder
        fetch('/api/update_survey_fields.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data) // Veriyi JSON olarak gönder
        })
            .then(response => response.json()) // JSON yanıtını çöz
            .then(result => {
                if (result.success) {
                    // Başarılı durum
                    loadFrame();
                } else {
                    // Hatalı durum
                    alert(result.message || 'An error occurred while updating.');
                }
            })
            .catch(error => {
                // Sunucuya bağlanılamadıysa hata mesajı göster
                console.error('Error updating survey field:', error);
                alert('Failed to update survey field. Please try again.');
            });
    }

    function getActiveSurveyFieldId() {
        const activeButton = document.querySelector("#questionsOutlineDiv button.active");
        return activeButton ? activeButton.getAttribute("data-id") : null;
    }

    function loadSurveyQuestions() {
        const surveyId = <?= $survey["id"] ?>;
        const containerId = "questionsOutlineDiv"; // Soruların ekleneceği container
        const container = document.getElementById(containerId);

        // Endpoint'e GET isteği gönder
        fetch(`/api/get_survey_fields.php?survey_id=${surveyId}`)
            .then(response => response.json())
            .then(data => {
                // Container içeriğini temizle
                container.innerHTML = "";

                // Başarı Durumu
                if (data.success && data.fields && data.fields.length > 0) {
                    // Gelen verilerle butonlar oluştur
                    data.fields.forEach((field, index) => {
                        const button = document.createElement("button");

                        // Buton özellikleri
                        button.className = "btn btn-secondary mb-2 w-100"; // Buton sınıfları
                        button.textContent = `Question ${index + 1}`; // Buton metni
                        button.style.display = "block"; // Alt alta butonlar için
                        button.setAttribute("data-id", field.id); // survey_fields id'sini ekle

                        // Tıklama olayını ata
                        button.addEventListener("click", function () {
                            // Diğer butonlardan "active" sınıfını kaldır
                            const buttons = container.querySelectorAll("button");
                            buttons.forEach(btn => {
                                btn.classList.remove("active");
                                btn.style.backgroundColor = ""; // Varsayılan rengi geri yükle
                            });

                            // Tıklanan butona "active" sınıfını ekle ve rengini ayarla
                            this.classList.add("active");
                            this.style.backgroundColor = "#9588E8"; // Aktif arka plan rengi
                            loadFrame();

                            // Aktif butonun ID'sini konsola yaz (isteğe bağlı)
                            console.log("Active Survey Field ID:", this.getAttribute("data-id"));
                        });

                        // Butonu konteynıra ekle
                        container.appendChild(button);
                    });

                    // Son butonu aktif yap
                    const lastButton = container.querySelector("button:last-child");
                    if (lastButton) {
                        lastButton.classList.add("active");
                        lastButton.style.backgroundColor = "#9588E8"; // Aktif arka plan rengi
                        loadFrame(); // Son aktif olan için frame'i yükle
                    }
                } else {
                    // Eğer sonuç yoksa mesaj göster
                    container.innerHTML = "<p>No questions found for this survey.</p>";
                }
            })
            .catch(error => {
                console.error("Error fetching survey fields:", error);

                // Hata durumunda mesaj göster
                container.innerHTML = "<p>Failed to load questions. Please try again later.</p>";
            });
    }


    loadSurveyQuestions();

    function deleteSurveyField(fieldId) {
        // SweetAlert2 ile onay al
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to delete this question? This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, keep it"
        }).then((result) => {
            if (result.isConfirmed) {
                // DELETE isteği gönder
                fetch(`/api/delete_survey_fields.php`, {
                    method: "DELETE",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ survey_fields_id: fieldId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Deleted!", "The question has been deleted.", "success");
                            loadSurveyQuestions(); // Soruları yeniden yükle
                        } else {
                            Swal.fire("Error", data.message || "Failed to delete the question.", "error");
                        }
                    })
                    .catch(error => {
                        console.error("Error deleting survey field:", error);
                        Swal.fire("Error", "Could not connect to the server.", "error");
                    });
            }
        });
    }

    const addQuestionButton = document.getElementById("addQuestionButton");

    // Tıklama Olayı
    addQuestionButton.addEventListener("click", function () {
        const surveyId = <?= $survey["id"] ?>; // PHP'den survey_id alıyoruz

        // AJAX İsteği
        fetch("/api/create_survey_fields.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ survey_id: surveyId }) // JSON formatında survey_id gönderiyoruz
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Başarılı Durum
                    loadSurveyQuestions();

                    Swal.fire(
                        "Success",
                        "New question has been added successfully!",
                        "success"
                    );
                } else {
                    // Başarısız Durum
                    Swal.fire(
                        "Error",
                        data.message || "An error occurred while adding the question.",
                        "error"
                    );
                }
            })
            .catch(error => {
                // Hata Durumu
                console.error("Error:", error);
                Swal.fire(
                    "Error",
                    "Could not connect to the server.",
                    "error"
                );
            });
    });


    const backgroundColorPicker = document.getElementById('backgroundColorPicker');
    const fontColorPicker = document.getElementById('fontColorPicker');
    const surveyContainer = document.getElementById('survey_general_container');
    const surveyFrame = document.getElementById('surveyFrame'); // Frame'i seç

    /**
     * Frame URL'sini günceller
     */
    function updateFrameURL() {
        const currentURL = new URL(surveyFrame.src); // Mevcut URL'yi al
        const selectedBackgroundColor = backgroundColorPicker.value;
        const selectedFontColor = fontColorPicker.value;

        // Query parametrelerini güncelle
        currentURL.searchParams.set('bg', selectedBackgroundColor);
        currentURL.searchParams.set('font', selectedFontColor);

        // Frame'in URL'sini güncelle
        surveyFrame.src = currentURL.toString();
    }

    // Arka Plan Rengi Değiştir
    backgroundColorPicker.addEventListener('input', function () {
        const selectedBackgroundColor = backgroundColorPicker.value;
        surveyContainer.style.backgroundColor = selectedBackgroundColor; // Container stilini değiştir
        updateSurvey({ id: <?=$survey["id"] ?>,backgroundColor: selectedBackgroundColor});
    });

    // Yazı Rengi Değiştir
    fontColorPicker.addEventListener('input', function () {
        const selectedFontColor = fontColorPicker.value;
        surveyContainer.style.color = selectedFontColor; // Container stilini değiştir
        updateSurvey({ id: <?=$survey["id"] ?>,fontColor: selectedFontColor});
    });

    document.getElementById('askQuestionButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Write down your Question!',
            input: 'text',
            inputPlaceholder: 'Type your question here...',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write something!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Log the question to the console
                console.log('Question:', result.value);

                // Placeholder for API request
                // You can send this data using fetch or any other method
                console.log('Sending question to API...');

                updateSurveyFields({
                    id: getActiveSurveyFieldId(),
                    title: result.value,
                })
                Swal.fire(
                    'Submitted!',
                    `Your question: "${result.value}" has been submitted.`,
                    'success'
                );
            }
        });
    });

    function loadFrame() {
        // Aktif olan survey_fields_id'yi al
        const survey_fields_id = getActiveSurveyFieldId();

        if (!survey_fields_id) {
            alert("No active survey field selected!");
            return;
        }

        // Endpoint'e GET isteği gönder
        fetch(`/api/get_frame_src.php?survey_fields_id=${survey_fields_id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Frame src'yi ayarla
                    const surveyFrame = document.getElementById("surveyFrame");
                    if (surveyFrame) {
                        surveyFrame.src = data.frame_src;
                    } else {
                        alert("Survey frame not found on the page!");
                    }
                } else {
                    // Endpoint hatası
                    alert(data.error || "Failed to load frame source.");
                }
            })
            .catch(error => {
                // Bağlantı hatası
                console.error("Error fetching frame source:", error);
                alert("An error occurred while loading the frame.");
            });
    }
</script>
</body>
</html>