<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['name']) && isset($_POST['details-email'])
     && isset($_POST['phone'])) {

    // Data validation
    if ( strlen($_POST['name']) < 1 || strlen($_POST['phone']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: customers.php");
        return;
    }

    if ( strpos($_POST['details-email'],'@') === false ) {
        $_SESSION['error'] = 'Bad data';
        header("Location: customers.php");
        return;
    }

    $sql = "INSERT INTO customers (name, email, phone, company, deadline, budget, additional)
              VALUES (:name, :email, :phone, :company, :deadline, :budget, :additional)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':email' => $_POST['details-email'],
        ':company' => $_POST['company'],
        ':deadline' => $_POST['deadline'],
        ':budget' => $_POST['budget'],
        ':additional' => $_POST['additional'],
        ':phone' => $_POST['phone']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: home.html' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>

