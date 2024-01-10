<?php
include 'db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
  case 'POST':
    createProduct($conn);
    break;
  case 'GET':
    readProducts($conn);
    break;
  case 'PUT':
    updateProduct($conn);
    break;
  case 'DELETE':
    deleteProduct($conn);
    break;
}

function createProduct($conn)
{
  parse_str(file_get_contents("php://input"), $post_vars);
  $product_cd = $post_vars['product_cd'];
  $name = $post_vars['name'];
  $product_type_cd = $post_vars['product_type_cd'];
  $date_offered = $post_vars['date_offered'];

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

function updateProduct($conn)
{
  parse_str(file_get_contents("php://input"), $put_vars);
  $product_cd = $put_vars['product_cd'];
  $name = $put_vars['name'];

  $sql = "UPDATE product SET NAME='$name' WHERE PRODUCT_CD='$product_cd'";
  if ($conn->query($sql) === TRUE) {
    echo "Produit mis à jour avec succès";
  } else {
    echo "Erreur de mise à jour: " . $conn->error;
  }
}

function deleteProduct($conn)
{
  parse_str(file_get_contents("php://input"), $delete_vars);
  $product_cd = $delete_vars['product_cd'];

  $sql = "DELETE FROM product WHERE PRODUCT_CD='$product_cd'";
  if ($conn->query($sql) === TRUE) {
    echo "Produit supprimé avec succès";
  } else {
    echo "Erreur de suppression: " . $conn->error;
  }
}

$conn->close();
