<!DOCTYPE html>
<?php $pageTitle = "Login | QuickSurvey"; ?>
<html lang="en">

<meta name="viewport" content="width=device-width, initial-scale=1">
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/partials/dependencies.php";

require_once $_SERVER["DOCUMENT_ROOT"]."/partials/auth_verify.php";
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://www.google.com/recaptcha/enterprise.js?render=6Leyy5cqAAAAAHkSwSVUWyzNrKPfeqzra06-Q0C-"></script>

<style>
    .btn-primary {
        background-color: #9588E8;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center vh-100" style="background-color: #9588E8; color: white;">
                <div>
                    <h3 style="text-align: center">Sign up<br> and come on in</h3>
                </div>
                <div>
                    <img src="https://media.istockphoto.com/id/1481596418/photo/3d-computer-laptop-with-checklist-and-pen-task-management-concept-to-do-list-with-check-mark.jpg?s=612x612&w=0&k=20&c=Sns5pxPO6UgmDaQPdkj50XLb5ma8BA-FEyPpHldnNOQ=" alt="Placeholder Image" style="width: 300px;">
                </div>
                <div style="position: absolute;bottom: 0">
                    <p>© QuickSurvey</p>
                </div>
            </div>
            <div class="col-md-7 d-flex justify-content-center align-items-center vh-100" style="border-radius: 15px; overflow: hidden;">
                <span style="position: absolute;top:15px;right: 15px">Not Registered Yet ? <a class="btn btn-link" style="color: black" href="/register">Sign Up Now</a></span>
                <form id="loginForm">
                    <img src="/public/img/Logo.jpg" style="width: 150px;height: auto">
                    <p>
                        Get better data with conversational forms, surveys, quizzes & more.
                    </p>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email Here!" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Your Pass Here!" class="form-control" required>
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-primary" type="submit">Log In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const formObject = Object.fromEntries(formData.entries());
            const apiUrl = '/admin/authentication/login.php';

            fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formObject)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Redirect to the dashboard
                        window.location.href = "/dashboard";
                    } else {
                        // Show an alert with the error message
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again later.');
                });
        });
    </script>

</body>

</html>