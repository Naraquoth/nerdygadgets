<!-- de inhoud van dit bestand wordt onderaan elke pagina geplaatst -->

<!DOCTYPE html>
<html>
<head>
<body>
<p style="color: rgb(0,0,0)"><?php echo("Did you know ".Nummer_Trivia(rand(1,400)));?></p>
</body>
</html>

<?php
function Nummer_Trivia($nummer){
    $url = 'http://numbersapi.com/'.$nummer.'/trivia';
    $crl = curl_init();
    curl_setopt($crl, CURLOPT_URL, $url);
    curl_setopt($crl, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($crl);
    curl_close($crl);
    return($response);}
?>