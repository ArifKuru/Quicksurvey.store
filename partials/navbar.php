<style>
    .navbar-nav .nav-item {
        display: flex;
        align-items: center; /* Dikey ortalama */
    }

</style>
<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard">
            <img src="/public/logo.png" alt="" style="height: 40px;"> <!-- Logonun yükseklik ayarı için style ekledim -->
        </a>
        <!-- Hamburger menü butonu (mobil görünüm için) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="background-color: transparent"></span>
        </button>
        <!-- Sağda bulunan menü -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link
                    <?php
                    if($current_page=="surveys.php"){
                        ?>
                          active
                    <?php
                    }
                    ?>

                     p-2" aria-current="page" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link     <?php
                    if($current_page=="all_surveys.php"){
                        ?>
                          active
                    <?php
                    }
                    ?>
                p-2" href="/surveys">Surveys</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link
                           <?php
                    if($current_page=="reports.php"){
                        ?>
                          active
                    <?php
                    }
                    ?>
                    p-2" href="/responses">Responses</a>
                </li>




                <!-- En sağda profile simgesi olan dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <!-- Profil ikonu -->
                        <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/admin/authentication/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
