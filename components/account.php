<?php
require_once "./lib/database.php";

    print_r($_POST);

    if(isset($_POST["terug-submit"])){
        unset($_SESSION["email"]);
        print_r($_SESSION);
    }

    if (isset($_POST["email-submit"]) || isset($_SESSION["email"])){
        if (isset($_POST["email"])){
            $_SESSION["email"] = $_POST["email"];
        }
        $accountByEmail = getPeopleByEmail($_SESSION["email"], $databaseConnection);
        if (count($accountByEmail) == 0) {
            require_once "./components/accountFroms/register.php";
        }
        else {
            require_once "./components/accountFroms/password.php";
        }

    } else {
        require_once "./components/accountFroms/email.php";
    }


?>

