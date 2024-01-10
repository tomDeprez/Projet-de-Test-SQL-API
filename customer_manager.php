<?php
include 'db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
  case 'POST':
    createCustomer($conn, $input);
    break;
  case 'GET':
    readCustomers($conn);
    break;
  case 'PUT':
    updateCustomer($conn, $input);
    break;
  case 'DELETE':
    deleteCustomer($conn, $input['cust_id']);
    break;
}

function createCustomer($conn, $data)
{
  $address = $data['address'];
  $city = $data['city'];
  $cust_type_cd = $data['cust_type_cd'];
  $fed_id = $data['fed_id'];
  $postal_code = $data['postal_code'];
  $state = $data['state'];

  $sql = "INSERT INTO customer (ADDRESS, CITY, CUST_TYPE_CD, FED_ID, POSTAL_CODE, STATE) VALUE ('$address', '$city', '$cust_type_cd', '$fed_id', '$postal_code', '$state')";

  if ($conn->query($sql) === TRUE) {
    echo "Nouveau client créé avec succès";
  } else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
  }
}

function readCustomers($conn)
{
  $sql = "SELECT * FROM customer";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "ID: " . $row["CUST_ID"] . " - Ville: " . $row["CITY"] . "<br>";
    }
  } else {
    echo "0 résultat";
  }
}


// function updateCustomer() { ... }

function deleteCustomer($conn, $custId)
{
  // Erreur intentionnelle : Mauvais paramètre
  $sql = "DELETE FROM customer WHERE CUST_ID='$custId'";
  if ($conn->query($sql) === TRUE) {
    echo "Client supprimé avec succès";
  } else {
    echo "Erreur de suppression: " . $conn->error;
  }
}

$conn->close();
