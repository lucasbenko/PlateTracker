<!DOCTYPE html>
<html lang="en">
<?php
include('config.php');
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

    <div class="justify-content-center align-items-center text-center" style="background-color: #231F20">
        <a class="display-4 s-heading" href="index">PlateTracker</a>
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
        <?php
        $hour = date('H');
        $greeting = '';

        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good evening';
        }
        ?>

        <?php if (isset($_COOKIE['id'])) {
            echo '<h1 class="s-heading-2 text-center"> ' . $greeting . ', ' . $_COOKIE["first_name"] .  ', what license plate did you see today?</h1>';
        } else {
            echo '<h1 class="s-heading-2 text-center"> ' . $greeting . ', please <a class="login-a" href="loginform">log in</a> to start tracking.</h1>';
        }
        ?>
        <main>
            <div class="container">
                <div class="row justify-content-center align-items-center text-center">

                    <?php
                    $mysqli = mysqli_connect("$db_host", "$db_username", "$db_password", "$db_database");
                    $targetid = $_COOKIE['id'];
                    $sql = "SELECT state FROM state_visits WHERE id = '$targetid'";

                    $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

                    $states_visited = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $states_visited[] = $row['state'];
                    }

                    $states = ["Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"];
                    foreach ($states as $state) {
                        echo '<div class="col-s d-flex justify-content-center align-items-center text-center">';
                        if (in_array($state, $states_visited)) {
                            echo '<button class="state-button state-button-visited" onclick="updateState(\'' . $state . '\', this)"';
                        } else {
                            echo '<button class="state-button" onclick="updateState(\'' . $state . '\', this)"';
                        }
                        if (!isset($_COOKIE['id'])) {
                            echo ' disabled';
                        }
                        echo '>';
                        if ($state == "District of Columbia") {
                            echo '<img src="res/icons/dc.svg" alt="District of Columbia">';
                        } else {
                            echo '<img src="res/icons/' . strtolower(str_replace(' ', '_', $state)) . '.svg" alt="' . $state . '">';
                        }
                        echo '<br>' . $state;
                        echo '</button>';
                        echo '</div>';
                        if ((array_search($state, $states) + 1) % 4 == 0) {
                            echo '</div><div class="row justify-content-center align-items-center text-center">';
                        }
                    }
                    ?>
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