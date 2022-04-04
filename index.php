<?php
function dump($el){
    print "<pre>";
    print_r($el);
    print "</pre>";
}

function convertCurrency($amount,$from_currency,$to_currency){
    $apikey = '3c989a08fcd4fd15a887';

    $from_Currency = urlencode($from_currency);
    $to_Currency = urlencode($to_currency);
    $query =  "{$from_Currency}_{$to_Currency}";

    // change to the free URL if you're using the free version
    $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
//    $json = http_get("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
    $obj = json_decode($json, true);

    $val = floatval($obj["$query"]);

    $total = $val * $amount;
    return number_format($total, 2, '.', '');
}

$value_from = isset($_POST["currency_from"]) ? (int) $_POST["currency_from"] : 0;
$from_currency = $_POST["currency_from_select"] ?? "";
$to_currency = $_POST["currency_to_select"] ?? "";
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $value_to = convertCurrency($value_from, $from_currency, $to_currency);
}
else{
    $value_to = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Time Currency Converter</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">CURRENCY CONVERTER</div>
        <form action="" method="POST">
            <div class="row">
                <input type="text" name="currency_from" placeholder="Enter amount" required="" value="<?= $value_from ?>">
                <select name="currency_from_select">
                    <option value="TRY" <?= $from_currency === "TRY" ? "selected" : ''?>>Turkish Lira</option>
                    <option value="USD" <?= $from_currency === "USD" ? "selected" : ''?> >United States Dollar</option>
                    <option value="EUR" <?= $from_currency === "EUR" ? "selected" : ''?>>Euro</option>
                </select>
            </div>
            <div class="row">
                <input type="text" name="currency_to" value="<?= $value_to ?>">
                <select name="currency_to_select">
                    <option value="TRY" <?= $to_currency === "TRY" ? "selected" : ''?>>Turkish Lira</option>
                    <option value="USD" <?= $to_currency === "USD" ? "selected" : ''?>>United States Dollar</option>
                    <option value="EUR" <?= $to_currency === "EUR" ? "selected" : ''?>>Euro</option>
                </select>
            </div>
            <div class="row">
                <button type="submit" name="convert_btn" value="convert">Convert</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

