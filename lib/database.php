<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php


function connectToDatabase() {
    $_ENV = parse_ini_file('.env');
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"], $_ENV["DB_PORT"]); //
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }
    if (!$DatabaseAvailable) {
        ?><h2>Website wordt op dit moment onderhouden.</h2><?php
        die();
    }

    return $Connection;
}

function getHeaderStockGroups($databaseConnection) {
    $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups 
                WHERE StockGroupID IN (
                                        SELECT StockGroupID 
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $HeaderStockGroups = mysqli_stmt_get_result($Statement);
    return $HeaderStockGroups;
}

function getStockGroups($databaseConnection) {
    $Query = "
            SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups 
            WHERE StockGroupID IN (
                                    SELECT StockGroupID 
                                    FROM stockitemstockgroups
                                    ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $StockGroups;
}

function getStockItem($id, $databaseConnection) {
    $Result = null;

    $Query = " 
           SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            TaxRate,
            RecommendedRetailPrice,
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    return $Result;
}

function getStockItemImage($id, $databaseConnection) {

    $Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    return $R;
}

function getPeopleByEmail($emailAddress, $databaseConnection) {
    $Query = "
                SELECT PersonID, EmailAddress
                FROM people
                WHERE EmailAddress = ? 
                LIMIT 1";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $emailAddress);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $People = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $People;
}

function createNewPeople($personName, $emailAddress, $password, $validatePassword, $databaseConnection) {
    $Query = "
                INSERT INTO `people` 
                (`FullName`, `PreferredName`, `SearchName`, `IsPermittedToLogon`, `LogonName`, `IsExternalLogonProvider`, `HashedPassword`, `IsSystemUser`, `IsEmployee`, `IsSalesperson`, `UserPreferences`, `PhoneNumber`, `FaxNumber`, `EmailAddress`, `Photo`, `CustomFields`, `OtherLanguages`, `LastEditedBy`, `ValidFrom`, `ValidTo`) 
                VALUES 
                ('', '', '', 0, '', 0, '', 0, 0, 0, '', '', '', ?, NULL, '', '', 1, CURRENT_TIMESTAMP, '9999-12-31 23:59:59.997')";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $emailAddress);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    return $Result;
}

// Users

function getCustomerByPeopleID($id, $databaseConnection) {
    $Query = "
    SELECT CU.CustomerID, CU.CustomerName, CU.PhoneNumber, CU.PostalPostalCode, CU.DeliveryAddressLine1, CU.DeliveryAddressLine2, CI.CityName
    FROM customers AS CU
    join cities AS CI ON CU.DeliveryCityID = CityID
    WHERE CU.PrimaryContactPersonID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Customer = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Customer;
}

// function createNewCustomerUnderPeopleID($id, $databaseConnection) {
//     $Query = "
//                 INSERT INTO `customers` 
//                 (`CustomerName`, `BillToCustomerID`, `CustomerCategoryID`, `PrimaryContactPersonID`, `AlternateContactPersonID`, `DeliveryMethodID`, `DeliveryCityID`, `PostalCityID`, `CreditLimit`, `AccountOpenedDate`, `StandardDiscountPercentage`, `IsStatementSent`, `IsOnCreditHold`, `PaymentDays`, `PhoneNumber`, `FaxNumber`, `DeliveryRun`, `RunPosition`, `WebsiteURL`, `DeliveryAddressLine1`, `DeliveryAddressLine2`, `DeliveryPostalCode`, `DeliveryLocation`, `PostalAddressLine1`, `PostalAddressLine2`, `PostalPostalCode`, `LastEditedBy`, `ValidFrom`, `ValidTo`) 
//                 VALUES 
//                 ('', NULL, NULL, ?, NULL, 1, NULL, NULL, 0.00, CURRENT_TIMESTAMP, 0.00, 0, 0, 0, '', '', NULL, NULL, '', '', '', '', '', '', '', '', 1, CURRENT_TIMESTAMP, '9999-12-31 23:59:59.997')";

//     $Statement = mysqli_prepare($databaseConnection, $Query);
//     mysqli_stmt_bind_param($Statement, "i", $id);
//     mysqli_stmt_execute($Statement);
//     $Result = mysqli_stmt_get_result($Statement);
//     return $Result;
// }

// Customers

function getOrderByCustomerId($id, $databaseConnection) {
    $Query = "
                SELECT OrderID, BackorderOrderID, OrderDate, ExpectedDeliveryDate 
                FROM `orders`
                WHERE `CustomerID` = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Order = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Order;
}


// Orders

function getOrderDetailsByOrderId($id, $databaseConnection) {
    $Query = "
                SELECT ol.StockItemID, si.StockItemName, ol.Quantity, ol.UnitPrice, ol.TaxRate, ol.PickedQuantity, ((ol.UnitPrice*(1+(ol.TaxRate/100)))*ol.PickedQuantity) AS TotalItemPrice
                FROM `orderlines` AS ol
                JOIN `stockitems` AS si ON ol.StockItemID = si.StockItemID
                WHERE ol.OrderID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $OrderDetails = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $OrderDetails;
}