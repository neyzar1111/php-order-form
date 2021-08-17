<?php


declare(strict_types=1);
////$newvar = [];
////$newvar = "string";
//
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// We are going to use session variables so we need to enable sessions
session_start();

// Use this function when you need to need an overview of these variables
function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

// TODO: provide some products (you may overwrite the example)
 $products  = [
    ['name' => 'Your favourite drink', 'price' => 2.5],
    ['name' => 'drink1', 'price' => 2.5],
    ['name' => 'drink2', 'price' => 2.5],
    ['name' => 'drink3', 'price' => 2.5],
    ['name' => 'drink4', 'price' => 2.5],
    ['name' => 'drink5', 'price' => 2.5],
];

$totalValue = 0;

function validate()
{
    $invalidFields = [];

    if (empty($_POST['email'])) {
        array_push($invalidFields, 'Please chek your email.');
    }
    if (empty($_POST['street'])) {
        array_push($invalidFields, 'Please chek your street.');
    }
    if (empty($_POST['streetnumber'])) {
        array_push($invalidFields, 'Please chek your streetnumber.');
    }
    if (empty($_POST['city'])) {
        array_push($invalidFields, 'Please chek your city.');
    }
    if (empty($_POST['zipcode'])) {
        array_push($invalidFields, 'Please chek zipcode.');
    }
    if (!is_numeric($_POST['zipcode'])) {
        array_push($invalidFields, 'Please chek zipcode should be number.');
    }
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        array_push($invalidFields, 'Invalid e-mail.');
    }

    return $invalidFields;
}

$chosenProducts = [];
function handleForm($products)
{
//    // TODO: form related tasks (step 1)
    $invField = validate();
    if($_POST["products"]!== NULL && count($invField) == 0){
        global $totalValue;
        global $chosenProducts;

        foreach($_POST["products"] as $x => $val) {
            $_SESSION["$x"] = $products[$x]['name'].' ------------- '.$products[$x]['price'];
            array_push($chosenProducts,$_SESSION["$x"]);
            $totalValue += $products[$x]['price'];
        }

    }
//    // Validation (step 2)
//    $invalidFields = validate();
    if (!empty($invField)) {
        // TODO: handle errors
        echo  '<div class="alert alert-danger">' . implode(" </br> ", $invField) .'</div>';
    } else{
        global $chosenProducts;
        global $totalValue;
        var_dump($chosenProducts);
        var_dump($totalValue);
        echo  ' <div class="alert alert-success">
            Your order is sumbited </br> Your address is: ' .$_POST['street'] . ' ' .$_POST['streetnumber'] . ' ' . ' ' .$_POST['city']
            .'</br>Your email is: ' .$_POST['email']
            .'</br> You have chosen:<br> ' .implode(" <br> ", $chosenProducts)
            .'</br> The total price is: &euro;' .number_format($totalValue, 2)
            .'</div>';
    }

}


// TODO: replace this if by an actual check

if (isset($_POST["submit"])) {
    handleForm($products);
}

require 'form-view.php';