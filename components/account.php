<?php
require_once "./lib/database.php";
// print_r($entryFile);

    // country-submit
    if(isset($_POST["terug-country-submit"])){
        unset($_SESSION["email"]);
    }
    if (isset($_POST["country-submit"])){
        $_SESSION["MyCountryID"] = $_POST["country"];
    }
    // province-submit
    if(isset($_POST["terug-province-submit"])){
        unset($_SESSION["MyCountryID"]);
    }
    if (isset($_POST["province-submit"])){
    $_SESSION["MyProvinceID"] = $_POST["province"];
    }
    // create-password-submit
    if(isset($_POST["terug-create-password-submit"])){
        unset($_SESSION["MyNewHasedPassword"]);
    }
    if (isset($_POST["create-password-submit"])){
        if ($_POST["new-password"] === $_POST["rep-new-password"]){
            $hasedPassword = password_hash($_POST["new-password"], PASSWORD_DEFAULT);
            $_SESSION["MyNewHasedPassword"] = $hasedPassword;
            header("Refresh:0"); // refresh de pagina
            die();
        } else {
            echo "<p> wachtwoord is niet het zelfde </p>";
        }
    }
    // register-submit
    if(isset($_POST["terug-register-submit"])){
        unset($_SESSION["MyProvinceID"]);
    }
    if(isset($_POST["register-submit"])){
        unset($_SESSION["MyCountryID"]);
        unset($_SESSION["MyProvinceID"]);
        // Array ( [voornaam] => jan [achternaam] => jhony [telefoonnummer] => 068527224 [zip] => 1239 XH [huisnummer] => 22 [straatnaam] => delta [woonplaats] => huizen [register-submit] => Volgende )
        // 1. maak people aan
        // 2. maak een customer aan
        // reload page met header
        
        $people_id = createNewPeople($_POST["full-name"], $_SESSION["email"],$_SESSION["MyNewHasedPassword"], $_POST["telefoonnummer"], $databaseConnection);
        unset($_SESSION["email"]);
        unset($_SESSION["EmailIsRegistered"]);
        unset($_SESSION["MyNewHasedPassword"]);
        $_SESSION["userID"] = $people_id;
        $customer_id = createNewCustomer($people_id, $_POST["full-name"], $_POST["telefoonnummer"], $_POST["huisnummer"], $_POST["straatnaam"], $_POST["zip"], $_POST["woonplaats"] , $databaseConnection);
        header("Refresh:0"); // refresh de pagina
        die();
    }

    if ((isset($_POST["email-submit"]) &&  isset($_POST["email"]))|| isset($_SESSION["email"])){
        if (!isset($_SESSION["email"]) && isset($_POST["email"])){
            $accountByEmail = getPeopleByEmail($_POST["email"], $databaseConnection);
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["EmailIsRegistered"] = (count($accountByEmail) !== 0);
        }

        if ($_SESSION["EmailIsRegistered"]) {
            if (isset($_POST["password-submit"])){

                $accountByEmail = getPeopleByEmail($_SESSION["email"], $databaseConnection);

                if (password_verify($_POST["password"], $accountByEmail[0]["HashedPassword"])){
                    $_SESSION["userID"] = $accountByEmail[0]["PersonID"];
                    header("Refresh:0"); // refresh de pagina
                    die();
                } else {
                    echo "<p> wachtwoord is niet het zelfde </p>";
                }
                            
            }
            require_once "./components/accountFroms/password.php";
            
        }
        else {
            if (!isset($_SESSION["MyCountryID"])){
                require_once "./components/accountFroms/country.php";
            } else if (!isset($_SESSION["MyProvinceID"])){
                require_once "./components/accountFroms/province.php";
            } else if (!isset($_SESSION["MyNewHasedPassword"])){
                require_once "./components/accountFroms/createPassword.php";
            } else {
                require_once "./components/accountFroms/register.php";
            }
        }

    } else {
        require_once "./components/accountFroms/email.php";
    }


?>