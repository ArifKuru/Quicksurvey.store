<!DOCTYPE html>
<?php
$pageTitle="Surveys | QuickSurvey";
?>
<html lang="en">

<?php require_once $_SERVER["DOCUMENT_ROOT"]."/partials/dependencies.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/partials/auth_verify.php";

?>

<body>
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/partials/navbar.php"?>
<div class="container mx-auto mt-3 "  style="min-height: 70vh">
    <div class="container-fluid p-0" style="position: relative;">
        <i>
            <img src="/public/surveys.svg?t=<?= time() ?>"
                 style="width: 100%; height: 250px;object-fit: cover; border-radius: 25px;border: 1px solid black">
        </i>
    </div>

    <div class="flex justify-between items-center mb-4 mt-3">
        <h2 class="text-2xl font-semibold text-gray-800">Your All Surveys</h2>

    </div>

    <!-- Survey Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="table-auto w-full">
            <thead class="bg-purple-100 text-purple-900">
            <tr>
                <th class="px-4 py-3 text-left">Survey Title</th>
                <th class="px-4 py-3 text-left">Created Date</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Actions</th>
            </tr>
            </thead>
            <tbody class="text-gray-700">
            <tr class="border-b">

            </tr>
            <!-- Repeat table rows for more surveys -->
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createSurveyModal" tabindex="-1" aria-labelledby="createSurveyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSurveyModalLabel">Create New Survey</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createSurveyForm">
                    <div class="mb-3">
                        <label for="surveyTitle" class="form-label">Survey Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="surveyTitle" placeholder="Enter survey title" required>
                    </div>
                    <div class="mb-3">
                        <label for="surveyDescription" class="form-label">Brief Description</label>
                        <textarea class="form-control" id="surveyDescription" rows="3" placeholder="Enter survey description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="expDate" class="form-label">Expiration Date</label>
                        <input type="date" class="form-control" id="expDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSurveyBtn">Save Survey</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createSurveyModalWithAi" tabindex="-1" aria-labelledby="createSurveyModalWithAiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="createSurveyModalWithAiLabel">Request AI Assistance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="aiSurveyRequestForm">
                    <div class="mb-3">
                        <label for="surveyRequest" class="form-label">Write your request for the survey</label>
                        <textarea class="form-control" id="surveyRequest" name="surveyRequest" rows="4" placeholder="Write here your request for survey"></textarea>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="sendToAiButton">Send to AI</button>
            </div>
        </div>
    </div>
</div>
<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/partials/footer.php";
?>
<script>
    document.getElementById('sendToAiButton').addEventListener('click', function() {
        const request = document.getElementById('surveyRequest').value;

        if (!request.trim()) {
            alert('Please write a request for the survey!');
            return;
        }

        fetch('/api/sendRequestToAi.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ request })
        })
            .then(response => response.json())
            .then(data => {
                alert('Survey request sent successfully!');
                // Modal'ı kapat
                const modal = bootstrap.Modal.getInstance(document.getElementById('createSurveyModalWithAi'));
                modal.hide();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while sending the request to AI.');
            });
    });



    async function deleteSurvey(surveyId) {
        try {
            // SweetAlert2 ile onay al
            const confirmation = await Swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to mark this survey as deleted?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            });

            if (confirmation.isConfirmed) {
                // Kullanıcı onayladı, API çağrısı yap
                const response = await fetch('/api/delete_survey.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: surveyId }),
                });

                const result = await response.json();

                if (result.success) {
                    // Başarılı sonuç mesajı
                    fetchSurveys();
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Survey deleted successfully!',
                        icon: 'success',
                    });
                } else {
                    // Başarısız sonuç mesajı
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete survey: ' + result.message,
                        icon: 'error',
                    });
                }
            } else {
                // Kullanıcı işlemi iptal etti
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Survey deletion was cancelled.',
                    icon: 'info',
                });
            }
        } catch (error) {
            // Hata durumunda mesaj
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while deleting the survey.',
                icon: 'error',
            });
            console.error('Error:', error);
        }
    }
    fetchSurveys();

    function fetchSurveys() {
        fetch('/api/list_surveys.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    populateTable(data.data);
                } else {
                    console.error('Error fetching surveys:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Function to populate the table with survey data
    function populateTable(surveys) {
        const tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        surveys.forEach(survey => {
            const expDate = new Date(survey.exp_date);
            const currentDate = new Date();
            const status = expDate >= currentDate ? 'Active' : 'Expired';

            const row = `
                <tr class="border-b">
                    <td class="px-4 py-3">${survey.title}</td>
                    <td class="px-4 py-3">${new Date(survey.created_at).toLocaleDateString()}</td>
                    <td class="px-4 py-3">
                        <span class="badge ${status === 'Active' ? 'bg-success' : 'bg-danger'}">${status}</span>
                    </td>
                    <td class="px-4 py-3">
                        <button class="text-blue-500 hover:text-blue-700 hint--top" aria-label="See Responses"><i class="fas fa-eye"></i></button>
                        <button class="text-green-500 hover:text-green-700 ml-3 hint--top" aria-label="Customize Survey" onclick="window.location.href='/survey/edit?h=${survey.hash_id}'"><i class="fas fa-edit"></i></button>
                        <button class="text-red-500 hover:text-red-700 ml-3 hint--top" aria-label="Delete Survey" onclick="deleteSurvey(${survey.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;

            tableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    document.getElementById('saveSurveyBtn').addEventListener('click', function () {
        // Get form values
        const title = document.getElementById('surveyTitle').value;
        const description = document.getElementById('surveyDescription').value;
        const expDate = document.getElementById('expDate').value;

        // Validate input
        if (!title) {
            alert('Survey Title is required!');
            return;
        }

        // Prepare data for POST request
        const formData = new FormData();
        formData.append('title', title);
        formData.append('description', description);
        formData.append('exp_date', expDate);

        // Send POST request
        fetch('/api/create_survey.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    fetchSurveys();
                    // Optionally close the modal and reset the form
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createSurveyModal'));
                    modal.hide();
                    document.getElementById('createSurveyForm').reset();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the survey.');
            });
    });

</script>
</body>
</html>