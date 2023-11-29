<?php
require_once "./lib/database.php";

    print_r($_POST);

    if(isset($_POST["terug-submit"])){
        unset($_SESSION["email"]);
        print_r($_SESSION);
    }

    if(isset($_POST["register-submit"])){
        // Array ( [voornaam] => jan [achternaam] => jhony [telefoonnummer] => 068527224 [zip] => 1239 XH [huisnummer] => 22 [straatnaam] => delta [woonplaats] => huizen [register-submit] => Volgende )
        // 1. maak people aan
        // 2. maak een customer aan
        // reload page met header
        
        $people_id = createNewPeople($_POST["full-name"], $_SESSION["email"], $_POST["telefoonnummer"], $databaseConnection);
        $_SESSION["userID"] = $people_id;
        $customer_id = createNewCustomer($people_id, $_POST["full-name"], $_SESSION["email"], $_POST["telefoonnummer"], $databaseConnection);
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

