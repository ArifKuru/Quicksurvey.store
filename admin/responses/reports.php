<!DOCTYPE html> 
<html lang="en">
<head>
    <link rel="stylesheet" href="/public/css/reports.css">
    <?php
    $pageTitle="Reports | QuickSurvey";
    require_once $_SERVER["DOCUMENT_ROOT"]."/partials/dependencies.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/partials/auth_verify.php";

    ?>
</head>
<body>


    <!-- Navbar -->
    <?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/partials/navbar.php";
    ?>
    <!-- Ana İçerik -->
    <main class="container my-3">
        <h1 class="text-center mb-4" ><img src="/public/responses.svg" style="height: 300px;width: 100%;object-fit: cover;border-radius: 25px"></h1>
        <div class="table-responsive mt-4">
            <table class="table table-striped align-start">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Survey Name</th>
                        <th scope="col">Responses</th>
                        <th scope="col">Charts</th>
                        <th scope="col">Text Responses</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr>
                        <td>Customer Feedback</td>
                        <td>150</td>
                        <td><button class="btn btn-primary btn-sm view-btn" data-id="101">View</button></td>
                        <td><button class="btn btn-secondary btn-sm text-btn" data-id="101">Text</button></td>
                    </tr>
                    <tr>
                        <td>Product Survey</td>
                        <td>120</td>
                        <td><button class="btn btn-primary btn-sm view-btn" data-id="102">View</button></td>
                        <td><button class="btn btn-secondary btn-sm text-btn" data-id="102">Text</button></td>
                    </tr>
                    <tr>
                        <td>Employee Engagement</td>
                        <td>200</td>
                        <td><button class="btn btn-primary btn-sm view-btn" data-id="103">View</button></td>
                        <td><button class="btn btn-secondary btn-sm text-btn" data-id="103">Text</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Grafik Modal -->
    <div id="modal" class="modal" style="display: none;">
        <div class="modal-content" style="width: 80%; height: 80%; position: relative;">
            <span class="close-btn" style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer;">&times;</span>
            <div id="chart-container" class="d-flex flex-wrap justify-content-center gap-3" 
                 style="overflow-y: auto; height: 100%; padding: 20px; box-sizing: border-box;">
                <!-- Grafikler buraya yüklenecek -->
            </div>
        </div>
    </div>



<!-- Text Cevap Modal -->
<div id="text-modal" class="modal" style="display: none;">
    <div class="modal-content" style="width: 60%; height: auto; position: relative; padding: 20px; border-radius: 8px; background: #fff;">
        <span class="close-text-modal" style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer; color: #000;">&times;</span>
        
        <div class="modal-header" style="display: flex; align-items: center; margin-bottom: 20px;">
            <i class="bi bi-chat-left-dots" style="font-size: 30px; margin-right: 10px;"></i>
            <h2 id="survey-title" style="font-size: 24px; margin: 0; color: #333;">Soru Başlığı</h2>
        </div>
        
        <div class="modal-body">
            <div id="response-date" style="font-size: 14px; color: #777; margin-bottom: 10px;"></div>
            <div class="text-container" style="overflow-y: auto; padding: 10px; border: 1px solid #ddd; border-radius: 5px; height: 300px; max-height: 300px;">
                <!-- Text cevaplar buraya yüklenecek -->
            </div>
        </div>
    </div>
</div>

<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/partials/footer.php";
?>

<script>


    function populateTable(surveys) {
        const tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        surveys.forEach(survey => {
            const expDate = new Date(survey.exp_date);
            const currentDate = new Date();

            const row = `
                <tr class="border-b">
                    <td class="px-4 py-3">${survey.title}</td>
                    <td class="px-4 py-3">
            ${survey.response_count}
                    </td>
                    <td class="px-4 py-3">
        <button class="btn btn-primary btn-sm view-btn" data-id="${survey.id}">View</button>
                    </td>

   <td class="px-4 py-3">
<button class="btn btn-secondary btn-sm text-btn" data-id="${survey.id}">Text</button>
                    </td>
                </tr>
            `;

            tableBody.insertAdjacentHTML('beforeend', row);

        });
        setupChartButtons();
        setupTextResponses();
    }

    fetchSurveys();
    function fetchSurveys() {
        fetch('/api/list_surveys.php')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log(data.data);
                    populateTable(data.data);
                } else {
                    console.error('Error fetching surveys:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    // API'den dinamik veri çekme
    // API'den dinamik veri çekme
    async function fetchChartData(surveyId) {
        try {
            const response = await fetch(`/api/getNumericalResponses.php?surveyId=${surveyId}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const responseData = await response.json();

            // Labels sabit yapılar
            const labelsConfig = {
                4: ['no', 'maybe', 'probably', 'sure'],
                3: ['😡', '😕', '😐', '🙂', '😍'],
                5: null,
                6: ['Yes', 'No'],
                9: null,
                10: ['1', '2', '3', '4', '5'],
                11: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10']
            };

            // Charts için data tipi
            const chartTypes = {
                4: 'bar',
                3: 'pie',
                5: 'bar',
                6: 'bar',
                9: 'bar',
                10: 'radar',
                11: 'radar'
            };

            // chartsData oluşturma
            const chartsData = [];

            responseData.forEach(item => {
                let labels;

                if (item.type_id === 3) {
                    labels = ['😡', '😕', '😐', '🙂', '😍'];
                    item.data.forEach(dataPoint => {
                        dataPoint.value = parseInt(dataPoint.value); // Veriyi sayıya çevir ve emojiye göre eşleştir
                    });
                } else if (item.type_id === 5 || item.type_id === 9) {
                    labels = Array.from(new Set(item.data.map(dataPoint => String(dataPoint.value))));
                } else if (item.type_id === 6) {
                    labels = ['Yes', 'No'];
                    item.data.forEach(dataPoint => {
                        dataPoint.value = dataPoint.value === "1" ? 'Yes' : 'No';
                    });
                } else {
                    labels = labelsConfig[item.type_id];
                }

                const type = chartTypes[item.type_id];

                if (!labels || !type) {
                    console.warn(`Labels or type not found for type_id: ${item.type_id}`);
                    return;
                }

                // Data dizisini oluşturma
                const data = Array(labels.length).fill(0);
                item.data.forEach(dataPoint => {
                    const labelIndex = item.type_id === 3
                        ? dataPoint.value - 1 // 1-5 arası sayıları emoji indeksine çevir
                        : labels.indexOf(String(dataPoint.value));
                    if (labelIndex !== -1) {
                        data[labelIndex] = dataPoint.count;
                    }
                });

                chartsData.push({
                    type,
                    data,
                    labels,
                    title: item.title || 'Untitled Chart'
                });
            });

            return chartsData;

        } catch (error) {
            console.error('Veri alınırken hata oluştu:', error);
        }
    }


    // Butonları tıklandığında grafik oluşturma
    let chartInstances = [];

    function setupChartButtons() {
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', async function () {
                const surveyId = this.getAttribute('data-id');
                const chartContainer = document.getElementById('chart-container');
                chartContainer.innerHTML = ''; // Clear previous charts

                const chartsData = await fetchChartData(surveyId);

                if (chartsData) {
                    chartsData.forEach((chartData, index) => {
                        const chartWrapper = document.createElement('div');
                        chartWrapper.style.width = '500px';
                        chartWrapper.style.height = '350px';
                        chartWrapper.style.margin = '20px';
                        chartWrapper.style.display = 'inline-block';
                        chartWrapper.style.verticalAlign = 'top';
                        chartWrapper.style.textAlign = 'center';

                        // Başlık ekleme
                        const chartTitle = document.createElement('h3');
                        chartTitle.textContent = chartData.title || 'Untitled Chart';
                        chartWrapper.appendChild(chartTitle);

                        const canvas = document.createElement('canvas');
                        canvas.id = `chart-${index}`;
                        chartWrapper.appendChild(canvas);
                        chartContainer.appendChild(chartWrapper);

                        const ctx = canvas.getContext('2d');
                        chartInstances.push(
                            new Chart(ctx, {
                                type: chartData.type,
                                data: {
                                    labels: chartData.labels,
                                    datasets: [{
                                        data: chartData.data,
                                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: { display: true },
                                        title: { display: true, text: chartData.title || 'Untitled Chart' }
                                    },
                                    maintainAspectRatio: false
                                }
                            })
                        );
                    });
                }

                // Modal Aç
                const modal = document.getElementById('modal');
                modal.style.display = 'flex';
            });
        });
    }

    const modal = document.getElementById('modal');
    const closeModalButton = document.querySelector('.close-btn');

    // Metin Modalı
    const textModal = document.getElementById('text-modal');
    const closeTextModalButton = textModal.querySelector('.close-text-modal');





    // Text Modalı tıklama işlemi
    async function setupTextResponses() {
        document.querySelectorAll('.text-btn').forEach(button => {
            button.addEventListener('click', async function () {
                const surveyId = this.getAttribute('data-id');
                const textContainer = document.querySelector('.text-container');
                const surveyTitle = document.getElementById('survey-title');
                const responseDate = document.getElementById('response-date');
                const textModal = document.getElementById('text-modal');

                textContainer.innerHTML = ''; // Clear previous responses

                try {
                    const response = await fetch(`/api/getTextResponses.php?surveyId=${surveyId}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const textResponses = await response.json();

                    // Add responses to the modal
                    textResponses.forEach(question => {
                        const questionTitle = document.createElement('h4');
                        questionTitle.textContent = question.title;
                        textContainer.appendChild(questionTitle);

                        question.data.forEach(response => {
                            const paragraph = document.createElement('p');
                            paragraph.textContent = `${response.value} (${response.count})`;
                            textContainer.appendChild(paragraph);
                        });
                    });

                    // Get the current date and time
                    const now = new Date();
                    const formattedDate = now.toLocaleString('en-US', { dateStyle: 'short', timeStyle: 'short' });
                    responseDate.textContent = `Date and Time: ${formattedDate}`;

                    // Open the modal
                    surveyTitle.textContent = 'Text Responses';
                    textModal.style.display = 'flex';
                } catch (error) {
                    console.error('Metin yanıtları alınırken hata oluştu:', error);
                }
            });
        });

        // Text Modal Kapatma
        const closeTextModalButton = document.querySelector('.close-text-modal');
        closeTextModalButton.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent event bubbling
            textModal.style.display = 'none';
        });

        // Text Modal Dışına Tıklandığında Kapat
        window.addEventListener('click', function (event) {
            if (event.target === textModal) {
                textModal.style.display = 'none';
            }
        });
    }
    // Text Modal Kapatma
    closeTextModalButton.addEventListener('click', function (event) {
        event.stopPropagation();  // Prevent event bubbling
        textModal.style.display = 'none';
    });

    // Text Modal Dışına Tıklandığında Kapat
    window.addEventListener('click', function (event) {
        if (event.target === textModal) {
            textModal.style.display = 'none';
        }
    });

    // Modal Kapatma
    closeModalButton.addEventListener('click', function (event) {
        event.stopPropagation();  // Prevent event bubbling
        modal.style.display = 'none';
        chartInstances.forEach(chart => chart.destroy());
        chartInstances = [];
    });

    // Modal Dışına Tıklandığında Kapat
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
            chartInstances.forEach(chart => chart.destroy());
            chartInstances = [];
        }});

    // Excel Export Fonksiyonu
    const exportButton = document.getElementById('export-btn');
    exportButton.addEventListener('click', () => {
        const table = document.querySelector('table');
        const workbook = XLSX.utils.table_to_book(table, { sheet: 'Sheet1' });
        XLSX.writeFile(workbook, 'survey_reports.xlsx');
    });

</script>
</body>
</html>
