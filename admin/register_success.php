<!DOCTYPE html>
<html lang="en">
<?php $pageTitle = "Register Successful! | QuickSurvey"; ?>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/partials/dependencies.php" ;
require_once $_SERVER["DOCUMENT_ROOT"]."/partials/auth_verify.php";
?>


<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6Leyy5cqAAAAAHkSwSVUWyzNrKPfeqzra06-Q0C-"></script>

    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>


<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5 d-flex flex-column justify-content-center align-items-center vh-100 order-md-2" style="background-color: #373737; color: white;">

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
                <span style="position: absolute; top: 15px; right: 15px; color: white;">Already have an account?
                    <a class="btn btn-link" style="color: white;" href="login">Log In</a>
                </span>
            <div class="celebration-container">
                <h1>🎉 Congratulations! 🎉</h1>
                <p>You have successfully registered. Please verify your email to get started!</p>
                <a href="/login" class="button btn" style="background-color: #666090;color: white">Go to Login</a>
                <div class="confetti">🎊🎉🎊</div>
            </div>
        </div>
    </div>
</div>


</body>

</html>