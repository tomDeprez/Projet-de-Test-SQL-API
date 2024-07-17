<?php
include 'db_connect.php';

//Thieu methode PUT
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
    deleteCustomer($conn, $input);
    // deleteCustomer($conn, $input['cust_id']);
    break;
}

// function GET readCustomers() { .OK.. }
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

// function POST createCustomer() { .OK.. }
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

// function PUT updateCustomer() { .OK.. }
function updateCustomer($conn, $input)
// updateCustomer($conn, $input);
{
  $CUST_ID = $input['CUST_ID'];
  $ADDRESS = $input['ADDRESS'];
  $CITY = $input['CITY'];
  $CUST_TYPE_CD = $input['CUST_TYPE_CD'];
  $FED_ID = $input['FED_ID'];
  $POSTAL_CODE = $input['POSTAL_CODE'];
  $STATE = $input['STATE'];
  // Ajouter d'autres champs ici si nécessaire
  $sql = "UPDATE customer SET CUST_ID='$CUST_ID', ADDRESS='$ADDRESS', CITY='$CITY', CUST_TYPE_CD='$CUST_TYPE_CD', FED_ID='$FED_ID', POSTAL_CODE='$POSTAL_CODE', STATE='$STATE' WHERE CUST_ID='$CUST_ID'";
  if ($conn->query($sql) === TRUE) {
    echo "customer mis à jour avec succès";
  } else {
    echo "Erreur de mise à jour: " . $conn->error;
  }
}

// function DELETE deleteCustomer() { ..OK. }
function deleteCustomer($conn, $data)
{
  // Erreur intentionnelle : Mauvais paramètre
  $CUST_ID = $data['CUST_ID'];
  $sql = "DELETE FROM customer WHERE CUST_ID='$CUST_ID'";
  if ($conn->query($sql) === TRUE) {
    echo "customer supprimé avec succès";
  } else {
    echo "Erreur de suppression: " . $conn->error;
  }
}



$conn->close();
