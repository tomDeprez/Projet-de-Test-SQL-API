<?php
include 'db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case "POST":
    createProduct($conn);
    break;
  case "GET":
    readProducts($conn);
    break;
  case "PUT":
    parse_str(file_get_contents("php://input"), $_PUT);
    updateProduct($conn, $_PUT);
    break;
  case "DELETE":
    parse_str(file_get_contents("php://input"), $_DELETE);
    deleteProduct($conn, $_DELETE);
    break;
  default:
    echo "Méthode HTTP non prise en charge";
}

function createProduct($conn)
{
  $product_cd = $_POST['product_cd'];
  $name = $_POST['name'];
  $product_type_cd = $_POST['product_type_cd'];
  $date_offered = $_POST['date_offered']; // format YYYY-MM-DD

  $sql = "INSERT INTO product (PRODUCT_CD, NAME, PRODUCT_TYPE_CD, DATE_OFFERED) VALUES ('$product_cd', '$name', '$product_type_cd', '$date_offered')";

  if ($conn->query($sql) === TRUE) {
    echo "Nouveau produit créé avec succès";
  } else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
  }
}

function readProducts($conn)
{
  $sql = "SELECT * FROM product";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "Code du produit: " . $row["PRODUCT_CD"] . " - Nom: " . $row["NAME"] . " - Type: " . $row["PRODUCT_TYPE_CD"] . "<br>";
    }
  } else {
    echo "0 résultat";
  }
}

function updateProduct($conn, $_PUT)
{
  $product_cd = $_PUT['product_cd'];
  $name = $_PUT['name']; // Nouveau nom du produit

  $sql = "UPDATE product SET NAME='$name' WHERE PRODUCT_CD='$product_cd'";

  if ($conn->query($sql) === TRUE) {
    echo "Produit mis à jour avec succès";
  } else {
    echo "Erreur de mise à jour: " . $conn->error;
  }
}

function deleteProduct($conn, $_DELETE)
{
  $product_cd = $_DELETE['product_cd'];

  $sql = "DELETE FROM product WHERE PRODUCT_CD='$product_cd'";

  if ($conn->query($sql) === TRUE) {
    echo "Produit supprimé avec succès";
  } else {
    echo "Erreur de suppression: " . $conn->error;
  }
}

$conn->close();
