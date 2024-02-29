<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-j0AQq+Vj7BAGVn6GOA26w1o9IR6Pxlb4R+38FyJg2Ul98WtSfxTfwejzUfiz60YHTGFjHuCEyl5+JZrD7Xrx5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/loginstyles.css">
</head>
<body>
    <div class="container mx-auto">
        <h2>Login</h2>
        <form action="/login" method="post">
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block my-2">Login</button>
        </form>
        <div class="or-divider">
            <span class="or-text">Or</span>
        </div>
        <div class="mt-3">
            <a href="<?= $google_login; ?>" class="btn btn-google my-2" onclick="loginWithGoogle()">
                <i class="fab fa-google google-icon"></i>Login with Google
            </a>
            <a href="<?= $facebook_login; ?> " class="btn btn-facebook my-2" onclick="loginWithFacebook()">
                <i class="fab fa-facebook-f facebook-icon"></i>Login with Facebook
            </a>
            <!-- <a href="<?= $logoutURL ?> " class="btn btn-facebook my-2" onclick="loginWithFacebook()">
                <i class="fab fa-facebook-f facebook-icon"></i>Logout with Facebook
            </a> -->
        </div>
    </div>

    <!-- Google Login Script -->
    <script>
        function loginWithGoogle() {
            // Redirect to Google login page or perform your authentication process
            window.location.href = "https://accounts.google.com";
        }
    </script>

    <!-- Facebook Login Script -->
    <script>
        function loginWithFacebook() {
            // Redirect to Facebook login page or perform your authentication process
            window.location.href = "https://www.facebook.com";
        }
    </script>
</body>
</html>
