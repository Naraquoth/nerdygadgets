<?php

function adminCheck($people)
{
    if (isset($_SESSION["userID"])) {
        if ($people["IsEmployee"] == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function adminOnly($people)
{
    if (isset($_SESSION["userID"])) {
        if ($people["IsEmployee"] == 1) {
            return true;
        } else {
            header("location: /");
            die();
        }
    } else {
        header("location: /");
        die();
    }
}