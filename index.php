<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- gjør at titellen ikke vises på siden -->
    <title style="display: none;">BTC - XAU - XAG</title>
</head>
<body>
    <h1>Priser til BTC, XAU, og XAG</h1>
    <?php
    // API 1 for BTC

    // starter curl
    $curl = curl_init();

    // lager et array som lagrer data som curl skal sende over
    curl_setopt_array($curl, [
        // url til api
        CURLOPT_URL => "https://coingecko.p.rapidapi.com/simple/price?ids=bitcoin&vs_currencies=nok&include_last_updated_at=false&include_market_cap=false&include_24hr_change=false&include_24hr_vol=false",
        // gjør at curl får en response tilbake
        CURLOPT_RETURNTRANSFER => true,
        // gjør at curl ikke blir redirektert til en helt annen nettside
        CURLOPT_FOLLOWLOCATION => true,
        // gjør at responsen blir ikke enkodert
        CURLOPT_ENCODING => "",
        // maks mengde av redireksjoner som kan skje
        CURLOPT_MAXREDIRS => 10,
        // om det har gått 30 sekunder og man har ikke fått responsen tilbake, cræsher nettsiden
        CURLOPT_TIMEOUT => 30,
        // versionen til HTTP
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // gjør at requesten er en GET, og ikke en post
        CURLOPT_CUSTOMREQUEST => "GET",
        // headeren som skal bli sendt over for å få en response
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: coingecko.p.rapidapi.com",
            "X-RapidAPI-Key: 4275419aabmshfab10bf5699c6c8p187720jsndc053e343e8f"
        ],
    ]);

    // to variabler, $response får å kjøre curl, og $err for å ta inn en error om curl cræsher
    $response = curl_exec($curl);
    $err = curl_error($curl);

    // lukker curl
    curl_close($curl);

    // hvis det skjer en error, så blir den vist
    if ($err) {
        echo "cURL Error #:" . $err;
    } 
    // ellers vil json filen som ble sendt tilbake bli dekodert, som da gjør det mulig å få spesifik informasjon tilbake, som i dette tilfellet er prisen på bitcoin i kroner
    else {
        $data = json_decode($response, true);
        echo '<h3 id="BTC">Prisen til 1 Bitcoin: ' . $data['bitcoin']['nok'] . 'kr</h3>';
    }

    // API 2 for gull og sølv
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://live-metal-prices.p.rapidapi.com/v1/latest/XAU,XAG/NOK/gram",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: live-metal-prices.p.rapidapi.com",
            // anbefalt om du bruker egen key, fordi det kan hende at kontoen har gått over quota til hvor mange ganger man kan sende en request
            "X-RapidAPI-Key: 4275419aabmshfab10bf5699c6c8p187720jsndc053e343e8f"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response, true);
        // nesten det samme som på linje 58, bare det at prisen på gull og sølv blir rundet ned til de 3 første desimalene
        echo '<h3 id="XAU">Prisen til 1g Gull: ' . round(($data['rates']['XAU']), 3) . 'kr</h3>';
        echo '<h3 id="XAG">Prisen til 1g Sølv: ' . round(($data['rates']['XAG']), 3) . 'kr</h3>';
    }
    ?>
</body>
<!-- importerer js timer som refresher siden hvert 5 min -->
<script src="timer.js"></script>
</html>