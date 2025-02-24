<!DOCTYPE html>
<html lang="en">
<?php $pageTitle = "Register | QuickSurvey"; ?>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/partials/dependencies.php" ;
require_once $_SERVER["DOCUMENT_ROOT"]."/partials/auth_verify.php";
?>



<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6Leyy5cqAAAAAHkSwSVUWyzNrKPfeqzra06-Q0C-"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5  d-none d-md-flex  flex-column justify-content-center align-items-center vh-100 order-md-2" style="background-color: #373737; color: white;">

                <div>
                    <h3 style="text-align: center;">Sign up<br> and come on in</h3>
                </div>
                <div>
                    <img src="https://cdn.sanity.io/images/b5fgx0yb/production/1bf60a2e6b5f05767d7bd9d48f1a7bfa6b14a8e2-2292x1210.webp?w=800&amp;auto=format" jsaction="" class="sFlh5c FyHeAf iPVvYb" style="max-width: 800px; height: 185px; margin: 0px; width: 351px;" alt="Placeholder Image" style="width: 300px;">
                </div>
                <div style="position: absolute; bottom: 0;">
                    <p>© QuickSurvey</p>
                </div>
            </div>
            <div class="col-md-7 d-flex justify-content-center align-items-center vh-100 order-md-1" style="border-radius: 15px; overflow: hidden;">
                <span style="position: absolute; top: 15px; right: 15px; color: dimgray;">Already have an account?
                    <a class="btn btn-link" style="color: dimgray;" href="login">Log In</a>
                </span>
                <form id="loginForm" action="/admin/authentication/register.php" method="POST">
                    <img src="/public/logo.png" style="width: 150px; height: auto;">
                    <p>Get better data with conversational forms, surveys, quizzes & more.</p>



                    <div class="form-group">
                        <label for="Email" style="text-decoration: none;">E-mail</label>
                        <input type="email" name="email" placeholder="Enter Your Email Here!" class="form-control" style="text-decoration: none;" required>
                    </div>

                    <div class="form-group">
                        <label for="pass" style="text-decoration: none;">Password</label>
                        <input type="password" name="password" placeholder="Enter Your Pass Here!" class="form-control" style="text-decoration: none;" required>
                    </div>

                    <div class="form-group">
                        <label for="Cname" style="text-decoration: none;">Company Name</label>
                        <input type="text" name="company_name" placeholder="Enter Your Company Name!" class="form-control" style="text-decoration: none;" required>
                    </div>
                    <div class="g-recaptcha mt-4" data-sitekey="6LcR_ZcqAAAAAJyoU2NWCeDUIfY_SwzuPu4qwCCz" data-action="LOGIN"></div>

                    <div class="form-group mt-4">
                        <button class="btn btn-primary" style="background-color: #9588E8;" type="submit">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Formu gönderme

            // reCAPTCHA yanıtını al
            var recaptchaResponse = grecaptcha.getResponse();

            // Eğer reCAPTCHA doğrulaması yapılmamışsa, formu gönderme
            if (recaptchaResponse.length == 0) {
                event.preventDefault(); // Formu gönderme
                alert("Please verify the reCAPTCHA!");
            }
            else {
                // reCAPTCHA doğrulama başarılı, formu gönder
                var formData = new FormData(this); // Form verilerini al

                // Formu AJAX ile gönder
                var xhr = new XMLHttpRequest();
                xhr.open("POST", this.action, true); // Formun action özelliği kullanılarak gönderim yapılacak URL belirlenir

                // Yanıt geldiğinde
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Sunucudan gelen yanıtı al
                        var response = JSON.parse(xhr.responseText);

                        // Eğer yanıt "success" ise yönlendirme yap
                        if (response.status === "success") {
                            window.location.href = "/register/success"; // Başarıyla yönlendirme
                        } else {
                            alert("Error: " + response.message); // Hata mesajını göster
                        }
                    } else {
                        alert("There was an error with the request.");
                    }
                };

                // Hata durumunda
                xhr.onerror = function() {
                    alert("An error occurred. Please try again.");
                };

                // Form verilerini gönder
                xhr.send(formData);
            }
        });
    </script>

</body>

</html>