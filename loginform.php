<!DOCTYPE html>
<html lang="en">
<?php
include('config.php');

if (isset($_COOKIE['auth'])) {
    header('Location: index');
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlateTracker</title>
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5e1f571de9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="stylesheet.css">

    <script>

    </script>
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="justify-content-center align-items-center text-center p-4" style="background-color: #231F20">
        <a href="index">
            <img src="res/img/logo-white.png" alt="PlateTracker Logo" style="max-width: 100%; height: auto; width: 200px;">
        </a>
    </div>

    <div class="container p-4">

        <nav class="navbar-expand-lg mb-4">
            <ul class="nav justify-content-center">
                <li class="nav-item nav-selector"><a class="nav-link nav-selector" href="index">Home</a></li>
                <?php if (isset($_COOKIE['id'])) {
                    echo '<li class="nav-item"><a class="nav-link nav-selector" href="logout"">Logout</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link nav-selector" href="loginform">Login</a></li>';
                }
                ?>
            </ul>
        </nav>

        <main>
            <div class="container">
                <div class="row justify-content-center p-2 align-items-center text-center">
                    <form method="post" action="userlogin.php">
                        <h1 class="s-heading-2"> Login</h1>
                            <?php
                            if (isset($_SESSION['account_created_message'])) {
                                echo '<p>' . $_SESSION['account_created_message'] . '</p>';
                                unset($_SESSION['account_created_message']);
                            } ?>
                            <p>
                                <input type="text" name="email" placeholder="Email Address" required />
                            </p>
                            <p>
                                <input type="password" name="password" placeholder="Password" required />
                            </p>
                            <p><input type="submit" name="submit" value="Login" /></p>
                    </form>
                </div>
                <div class="row justify-content-center p-2 align-items-center text-center">
                    Don't have an account yet? &nbsp;
                    <a href="createaccount" class="nav-selector">Sign up</a>
                </div>
            </div>
    </div>
    </main>
    </div>

    <footer class="text-center mt-auto w-100" style="background-color: #231F20">
        <div class="container">
            <div class="row justify-content-center my-2" style="color: #EFE6DD;">&copy;
                <script>
                    document.write(/\d{4}/.exec(Date())[0])
                </script> Lucas Benko
            </div>
        </div>
    </footer>
    <script src="script.js"></script>
</body>

</html>