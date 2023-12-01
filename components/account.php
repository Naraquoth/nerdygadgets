<?php
require_once "./lib/database.php";

    // country-submit
    if(isset($_POST["terug-country-submit"])){
        unset($_SESSION["email"]);
        print_r($_SESSION);
    }
    if (isset($_POST["country-submit"])){
        $_SESSION["MyCountryID"] = $_POST["country"];
    }
    // province-submit
    if(isset($_POST["terug-province-submit"])){
        unset($_SESSION["MyCountryID"]);
        print_r($_SESSION);
    }
    if (isset($_POST["province-submit"])){
    $_SESSION["MyProvinceID"] = $_POST["province"];
    }
    // register-submit
    if(isset($_POST["terug-register-submit"])){
        unset($_SESSION["MyProvinceID"]);
        print_r($_SESSION);
    }
    if(isset($_POST["register-submit"])){
        unset($_SESSION["MyCountryID"]);
        unset($_SESSION["MyProvinceID"]);
        // Array ( [voornaam] => jan [achternaam] => jhony [telefoonnummer] => 068527224 [zip] => 1239 XH [huisnummer] => 22 [straatnaam] => delta [woonplaats] => huizen [register-submit] => Volgende )
        // 1. maak people aan
        // 2. maak een customer aan
        // reload page met header
        
        $people_id = createNewPeople($_POST["full-name"], $_SESSION["email"], $_POST["telefoonnummer"], $databaseConnection);
        $_SESSION["userID"] = $people_id;
        $customer_id = createNewCustomer($people_id, $_POST["full-name"], $_POST["telefoonnummer"], $_POST["huisnummer"], $_POST["straatnaam"], $_POST["zip"], $_POST["woonplaats"] , $databaseConnection);
        header("Location: checkout.php"); // refresh de pagina
        die();
    }


    if ((isset($_POST["email-submit"]) &&  isset($_POST["email"]))|| isset($_SESSION["email"])){
        if (!isset($_SESSION["email"]) && isset($_POST["email"])){
            $accountByEmail = getPeopleByEmail($_POST["email"], $databaseConnection);
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["EmailIsRegistered"] = (count($accountByEmail) == 0);
        }

        if ($_SESSION["EmailIsRegistered"]) {
            if (isset($_SESSION["MyCountryID"]) && isset($_SESSION["MyProvinceID"])){
                require_once "./components/accountFroms/register.php";
            } else if (isset($_SESSION["MyCountryID"])){
                require_once "./components/accountFroms/province.php";
            } else{
                require_once "./components/accountFroms/country.php";
            }
        }
        else {
            $_SESSION["userID"] = $accountByEmail[0]["PersonID"];
            header("Location: checkout.php"); // refresh de pagina
            die();

            // login form ?

            // require_once "./components/accountFroms/password.php";
        }

    } else {
        require_once "./components/accountFroms/email.php";
    }


?>

