<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle; ?></title>
    <link rel="icon" type="image/x-icon" href="/public/favico_s.png">
    <meta name="description" content="QuickSurvey is new generation survey platform which use AI systems to increase efficiency in survey feedbacks and analysing data!"> <!-- SEO için açıklama -->
    <meta name="keywords" content="survey, AI-powered surveys, data analysis"> <!-- SEO için anahtar kelimeler -->
    <meta name="author" content="QuickSurvey.Store"> <!-- Sayfanın yazarı -->
    <!---custom css link -->
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" type="text/css" href="/public/css/style.css?v=3">
    <!---boxicons link -->
    <link rel="stylesheet"
          href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <!--- google fonts icon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com"crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<header>
    <a href="/" class="logo">  <img> Quick<span>survey</span></a>
    <ul class="navbar">
        <li><a href="/">Home</a></li>
        <li><a href="/information">Information</a></li>


        <li><a href="/us">About Us</a></li>

        <form action="https://quicksurvey.store/login" target="_blank">
            <input type="submit" value="Get started" class="btn">
        </form>
        <script>
            function goToSurveyPage() {
                window.location.href = "https://quicksurvey.store/login";
            }
        </script>
    </ul>
</header>
