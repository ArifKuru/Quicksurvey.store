<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.9.6/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap Icons eklemek için -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css"> <!-- Eğer harici bir CSS dosyası kullanıyorsan -->
    <style>
        /* Sayfanın yüksekliğini dolduracak şekilde ayarlıyoruz */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Sayfanın en az tüm görünüm yüksekliğini kaplaması için */
        }

        /* Footer'ı en alta sabitlemek için */
        footer {
            background-color: #373737; /* Arka plan rengi ayarlandı */
            color: white; /* Yazı rengi beyaz yapıldı */
        }

        
    </style>
</head>

<body>
    <!-- Navbar -->
<?php require_once $_SERVER["DOCUMENT_ROOT"]."/partials/navbar.php" ;?>
    <!-- Carousel -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
        <!--Graph Card-->
        <div class="bg-white border-transparent rounded-lg shadow-xl">
            <div class="bg-gradient-to-b from-[#cac3f3] to-[#9588e8] uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-[#373737]">Comments and Ratings</h5>
            </div>
            <div class="p-5">
                <canvas id="chartjs-4" class="chartjs" width="undefined" height="undefined"></canvas>
                <script>
                    new Chart(document.getElementById("chartjs-4"), {
                        type: "doughnut",
                        data: {
                            labels: ["1 Star", "2 Stars", "3 Stars", "4 Stars", "5 Stars"],
                            datasets: [{
                                label: "Ratings",
                                data: [5, 10, 15, 25, 45],
                                backgroundColor: ["#9588e8", "#cac3f3", "#66090", "#373737", "#5a5a5a"]
                            }]
                        }
                    });
                </script>
            </div>
        </div>
        <!--/Graph Card-->
    </div>

    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
        <!--Advert Card-->
        <div class="bg-white border-transparent rounded-lg shadow-xl">
            <div class="bg-gradient-to-b from-[#cac3f3] to-[#9588e8] uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                <h2 class="font-bold uppercase text-[#373737]">Contact and Support</h2>
            </div>
            <div class="p-5 text-center">
                <p class="text-[#373737]">Contact us for assistance:</p>
                <ul class="text-left">
                    <li>Phone: 123-456-7890</li>
                    <li>Email: support@event.com</li>
                    <li><a href="#" class="text-[#9588e8]">Social Media</a></li>
                </ul>
            </div>
        </div>
        <!--/Advert Card-->
    </div>
</section>
</main>
</div>
    

    <!-- Diğer içerik buraya gelecek -->
    <div class="flex-grow-1"></div> <!-- İçeriğin altında footer'ı sabitlemek için boş bir alan bırakıyoruz -->

    <!-- Footer -->
    <footer class="text-center text-lg-start mt-auto">
        <!-- Copyright -->
        <div class="text-center p-3">
            © 2024 QuickSurvey. All rights reserved.
            <a class="text-light" href="#">Privacy Policy</a> |
            <a class="text-light" href="#">Terms of Service</a>
        </div>
        <!-- Copyright -->
    </footer>

    <!-- Bootstrap'ın JavaScript dosyalarını eklemek (navbar'ın toplanıp açılması için gerekli) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
