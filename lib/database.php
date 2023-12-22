<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php
require_once "./lib/blobFuncties.php";


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

// country, province and city

function getCountries($databaseConnection) {
    $Query = "
                SELECT CountryID, CountryName FROM `countries`";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Countries = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Countries;
}

function getProvincesByCountryId($id, $databaseConnection) {
    $Query = "
                SELECT StateProvinceID, StateProvinceName FROM `stateprovinces` WHERE `CountryID` = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Provinces = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Provinces;
}

function getCitiesByProvinceId($id, $databaseConnection) {
    $Query = "
                SELECT CityID, CityName FROM `cities` WHERE `StateProvinceID` = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Cities = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Cities;
}


// products
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
            UnitPackageID,
            IsChillerStock, 
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
//banner

function insertSlider($SliderName, $ImagePath, $StockItemID, $databaseConnection) {
    
    $Query = "INSERT INTO sliderimage (SliderName, ImagePath, StockItemID) VALUES (?,?,?)";
    
    $Statement = mysqli_prepare($databaseConnection, $Query);
    $Statement->bind_param("ssi",$SliderName, $ImagePath, $StockItemID);
    mysqli_stmt_execute($Statement);
    return mysqli_insert_id($databaseConnection);
}
function updateSlider($SliderName, $ImagePath, $StockItemID, $SliderID, $databaseConnection) {
    
    $Query = "UPDATE sliderimage SET SliderName = ?, ImagePath = ?, StockItemID = ? WHERE SliderID = ?";
    
    $Statement = mysqli_prepare($databaseConnection, $Query);
    $Statement->bind_param("ssii",$SliderName, $ImagePath, $StockItemID, $SliderID);
    mysqli_stmt_execute($Statement);
    return mysqli_insert_id($databaseConnection);
}

function deleteSlider($SliderID, $databaseConnection) {
    
    $Query = "DELETE FROM sliderimage WHERE SliderID = ?";
    
    $Statement = mysqli_prepare($databaseConnection, $Query);
    $Statement->bind_param("i",$SliderID);
    $success = mysqli_stmt_execute($Statement);
    return $success;
}
function getSliderImages($id, $databaseConnection) {
   
    $query = "SELECT ImagePath FROM sliderimage WHERE SliderID = ?";
    $stmt = $databaseConnection->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = $result->fetch_all(MYSQLI_ASSOC);
    return $images;
}
function getSliderID($databaseConnection) {

    $query = "SELECT SliderID FROM sliderimage";
    $stmt = $databaseConnection->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $ids = $result->fetch_all(MYSQLI_NUM);
    // Flatten the array of arrays into a simple array of IDs
    $ids = array_map(function($item) {
        return $item[0];
    }, $ids);
    return $ids;
}

    function getSliderStockID($id, $databaseConnection) {

        $Query = "
                    SELECT StockItemID
                    FROM sliderimage 
                    WHERE SliderID = ?";
    
        $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_bind_param($Statement, "i", $id);
        mysqli_stmt_execute($Statement);
        $result = mysqli_stmt_get_result($Statement);
        $stockitemid = mysqli_fetch_assoc($result)['StockItemID'];
        return $stockitemid;
    }
    function getSlider($databaseConnection) {

        $query = "SELECT * FROM sliderimage";
        $stmt = $databaseConnection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $slides = $result->fetch_all(MYSQLI_NUM);
        return $slides;
    }

    function getSliderByID($id, $databaseConnection) {
   
        $query = "SELECT * FROM sliderimage WHERE SliderID = ?";
        $stmt = $databaseConnection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = $result->fetch_all(MYSQLI_ASSOC);
        return $images;
    }
// Users account.

function getPeopleByEmail($emailAddress, $databaseConnection) {
    $Query = "
                SELECT PersonID, EmailAddress, HashedPassword
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

function getPeopleById($id, $databaseConnection) {
    $Query = "
                SELECT PersonID, EmailAddress, IsEmployee
                FROM people
                WHERE PersonID = ? 
                LIMIT 1";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $People = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $People;
}

function createNewPeople($personName, $emailAddress, $hasedPassword, $phoneNumber, $databaseConnection) {
    $dateTimeNow = date("Y-m-d H:i:s");
    $Query = "
                INSERT INTO `people` 
                (`FullName`, `PreferredName`, `SearchName`, `IsPermittedToLogon`, `LogonName`, `IsExternalLogonProvider`, `HashedPassword`, `IsSystemUser`, `IsEmployee`, `IsSalesperson`, `UserPreferences`, 
                `PhoneNumber`, `FaxNumber`, `EmailAddress`, `Photo`, `CustomFields`, `OtherLanguages`, `LastEditedBy`, `ValidFrom`, `ValidTo`) 
                VALUES 
                (?, ?, ?, 0, 'NO LOGON', 0, ?, 0, 0, 0, NULL, ?, NULL, ?, NULL, NULL, NULL, 1, ?, '9999-12-31 23:59:59.000000')";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    $Statement->bind_param("sssssss", $personName, $personName, $personName, $hasedPassword, $phoneNumber,  $emailAddress, $dateTimeNow);
    mysqli_stmt_execute($Statement);
    return mysqli_insert_id($databaseConnection);
}

// Customers
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

function createNewCustomer($peopleID, $personName, $phoneNumber, $deliveryaddress1 , $deliveryaddress2, $postcode, $woonplaatsID,  $dbConn) {
    $dateTimeNow = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    
    $dbConn->begin_transaction();

    $dbConn->prepare("SET FOREIGN_KEY_CHECKS=0")->execute();

    // customerCategoryID needs to be changed to a new record is added to the customerCategories table for NerdyGadgets Shop

    $query1 = "
                INSERT INTO `customers` 
                (`CustomerName`, `BillToCustomerID`, `CustomerCategoryID`, `BuyingGroupID`, `PrimaryContactPersonID`, `AlternateContactPersonID`, `DeliveryMethodID`, `DeliveryCityID`, `PostalCityID`, `CreditLimit`, `AccountOpenedDate`, `StandardDiscountPercentage`, `IsStatementSent`, `IsOnCreditHold`, `PaymentDays`, `PhoneNumber`, `FaxNumber`, `DeliveryRun`, `RunPosition`, `WebsiteURL`, `DeliveryAddressLine1`, `DeliveryAddressLine2`, `DeliveryPostalCode`, `DeliveryLocation`, `PostalAddressLine1`, `PostalAddressLine2`, `PostalPostalCode`, `LastEditedBy`, `ValidFrom`, `ValidTo`)
                VALUES 
                (?, 0, 3, NULL, ?, NULL, 3, ?, ?, 0.00, ?, 0.000, 0, 0, 7, ?, '', NULL, NULL, 'nerdygadgets.shop', ?, ?, ?, NULL, ?, ?, ?, 1, ?, '9999-12-31 23:59:59.000000')";
    $stmt1 = $dbConn->prepare($query1);
    $stmt1->bind_param("siiisssssssss", $personName, $peopleID, $woonplaatsID, $woonplaatsID, $date, $phoneNumber, $deliveryaddress1 , $deliveryaddress2, $postcode, $deliveryaddress1 , $deliveryaddress2, $postcode, $dateTimeNow);
    $stmt1->execute();
    if ($stmt1->affected_rows > 0) {
        $newCustomerID = $dbConn->insert_id;

        $query2 = "UPDATE customers SET BillToCustomerID = ? WHERE customerID = ?";

        $stmt2 = $dbConn->prepare($query2);

        $stmt2->bind_param("ii", $newCustomerID, $newCustomerID);

        $stmt2->execute();

        $dbConn->prepare("SET FOREIGN_KEY_CHECKS=1")->execute();

        $dbConn->commit();

        return $newCustomerID;

    } else {
        $dbConn->rollback();
        print_r($stmt1->error);
        return null;
    }    
}

// Orders

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

function createNewOrder($customerID, $userID, $cartItemsArray, $dbConn) { 
    $dateTimeNow = date("Y-m-d H:i:s");
    $date = date("Y-m-d");
    $dateExpectedDelivery = date("Y-m-d", strtotime($date. ' + 7 days'));

    $dbConn->begin_transaction();

    $query1 = "INSERT INTO `orders`
     (`CustomerID`, `SalespersonPersonID`, `PickedByPersonID`, `ContactPersonID`, `BackorderOrderID`, `OrderDate`, `ExpectedDeliveryDate`, `CustomerPurchaseOrderNumber`, `IsUndersupplyBackordered`, `Comments`, `DeliveryInstructions`, `InternalComments`, `PickingCompletedWhen`, `LastEditedBy`, `LastEditedWhen`)
      VALUES 
      (?, 1, NULL, ?, NULL, ?, ?, NULL, 0, NULL, NULL, NULL, NULL, 1, ?)";
    $stmt1 = $dbConn->prepare($query1);
     $stmt1->bind_param("iisss", $customerID, $userID, $date, $dateExpectedDelivery, $dateTimeNow);
    $stmt1->execute();
    if ($stmt1->affected_rows > 0) {
        $newOrderID = $dbConn->insert_id;
        // $query2 = "INSERT INTO `invoices` 
        // (`CustomerID`, `BillToCustomerID`, `OrderID`, `DeliveryMethodID`, `ContactPersonID`, `AccountsPersonID`, `SalespersonPersonID`, `PackedByPersonID`, `InvoiceDate`, `CustomerPurchaseOrderNumber`, `IsCreditNote`, `CreditNoteReason`, `Comments`, `DeliveryInstructions`, `InternalComments`, `TotalDryItems`, `TotalChillerItems`, `DeliveryRun`, `RunPosition`, `ReturnedDeliveryData`, `ConfirmedDeliveryTime`, `ConfirmedReceivedBy`, `LastEditedBy`, `LastEditedWhen`) 
        // VALUES 
        // (?, ?, ?, 3, ?, ?, 1, 1, ?, NULL, 0, NULL, NULL, NULL, NULL, ?, 0, NULL, NULL, NULL, NULL, NULL, 1, ?)";
        // $stmt2 = $dbConn->prepare($query2);
        // $totalItems = count($cartItemsArray);
        // $stmt2->bind_param("iiiiisis", $customerID, $customerID, $newOrderID, $userID, $userID, $date, $totalItems, $dateTimeNow);
        // $stmt2->execute();
        // $newInvoiceID = $dbConn->insert_id;

        // $query3 = "INSERT INTO `customertransactions` 
        // (`CustomerID`, `TransactionTypeID`, `InvoiceID`, `PaymentMethodID`, `TransactionDate`, `AmountExcludingTax`, `TaxAmount`, `TransactionAmount`, `OutstandingBalance`, `FinalizationDate`, `IsFinalized`, `LastEditedBy`, `LastEditedWhen`)
        // VALUES 
        // (?, 3, ?, 5, '', '', '', '', '', NULL, 0, 1, ?)";
        // $stmt3 = $dbConn->prepare($query3);
        // $stmt3->bind_param("iis", $customerID, $newInvoiceID, $dateTimeNow);
        // $stmt3->execute();

        foreach ($cartItemsArray as $stockItem){
            $query4 = "INSERT INTO 
            `orderlines` (`OrderID`, `StockItemID`, `Description`, `PackageTypeID`, `Quantity`, `UnitPrice`, `TaxRate`, `PickedQuantity`, `PickingCompletedWhen`, `LastEditedBy`, `LastEditedWhen`)
            VALUES
            (?, ?, ?, ?, ?, ?, ?, 0, NULL, 1, ?)";
            $stmt4 = $dbConn->prepare($query4);
            $stmt4->bind_param("iisiidds",$newOrderID, $stockItem["StockItemID"], $stockItem["StockItemName"], $stockItem["UnitPackageID"], $stockItem["aantal"], $stockItem["SellPrice"], $stockItem["TaxRate"], $dateTimeNow);
            $stmt4->execute();
        }

        $dbConn->commit();

        return $newOrderID;

    } else {
        $dbConn->rollback();
        print_r($stmt1->error);
        return null;
    }

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

// vooraad aanpassen.

function changeInventoryByOrderId($orderId, $dbconn){

    $query1 = "SELECT * FROM `orderlines` WHERE `OrderID` = ?";
    $Statement1 = mysqli_prepare($dbconn, $query1);
    mysqli_stmt_bind_param($Statement1, "i", $orderId);
    mysqli_stmt_execute($Statement1);
    $Result1 = mysqli_stmt_get_result($Statement1);


    foreach($Result1 as $row){
        $query2 = "UPDATE stockitemholdings SET QuantityOnHand = (QuantityOnHand - ?) WHERE StockItemID = ?";
        $Statement2 = mysqli_prepare($dbconn, $query2);
        mysqli_stmt_bind_param($Statement2, "ii", $row["Quantity"], $row["StockItemID"] );
        mysqli_stmt_execute($Statement2);
    }

}
function insertSensorData($sensorId, $tempratuur, $datetime, $dbconn){
    $dateTimeNow = date("Y-m-d H:i:s");
    $query1 = "INSERT INTO `coldroomtemperatures`
    (`ColdRoomTemperatureID`, `ColdRoomSensorNumber`, `RecordedWhen`, `Temperature`, `ValidFrom`, `ValidTo`)
VALUES 
    (NULL, ?, ?, ?, ?, ?)";
    $statement1 = mysqli_prepare($dbconn,$query1);
    mysqli_stmt_bind_param($statement1, "isdss", $sensorId, $datetime, $tempratuur, $dateTimeNow, $dateTimeNow);
    mysqli_stmt_execute($statement1);

    $query2 = "DELETE FROM `coldroomtemperatures` WHERE `ColdRoomSensorNumber` = 5 AND `ColdRoomTemperatureID` <> (
                SELECT MAX(`ColdRoomTemperatureID`) FROM `coldroomtemperatures` WHERE `ColdRoomSensorNumber` = 5
            )";
    mysqli_query($dbconn, $query2);
}

function GetChiller5($dbconn){
    $query1 = "SELECT `Temperature` FROM `coldroomtemperatures` WHERE `ColdRoomSensorNumber` = 5 LIMIT 1";
    $result = mysqli_query($dbconn, $query1);
    $temp = mysqli_fetch_assoc($result);
    $faketemp = $temp['Temperature'] - 40;
    return $faketemp;


}
//Toenen van stockitemID quantity (Meest 3 verkochte producten).

function meestVerkochtProduct($limit, $databaseConnection){
    $Query = "
        SELECT StockItemID, SUM(quantity) AS totalQuantity
        FROM orderlines
        GROUP BY StockItemID 
        ORDER BY totalQuantity DESC
        LIMIT ?;
    ";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $limit);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);

    $meestVerkocht = [];

    while ($row = mysqli_fetch_assoc($Result)) {
        $meestVerkocht[] = $row;
    }

    mysqli_stmt_close($Statement);

    return $meestVerkocht;
}