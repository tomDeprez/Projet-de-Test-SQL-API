<?php
include 'db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
  case 'POST':
    createProduct($conn,$input);
    break;
  case 'GET':
    readProducts($conn);
    break;
  case 'PUT':
    updateProduct($conn,$input);
    break;
  case 'DELETE':
    deleteProduct($conn,$input);
    break;
}

// function GET readProducts() { ..OK.. } thay doi ten in ra Nom = Name
function readProducts($conn)
{
  $sql = "SELECT * FROM product";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      // echo "Code du produit: " . $row["PRODUCT_CD"] . " - Nom: " . $row["NAME"] . " - Type: " . $row["PRODUCT_TYPE_CD"] . "<br>";
      echo "Code du produit: " . $row["PRODUCT_CD"] . " - Name: " . $row["NAME"] . " - Type: " . $row["PRODUCT_TYPE_CD"] . "<br>";
    }
  } else {
    echo "0 résultat";
  }
}

// function POST createProduct() { ..OK.. }
function createProduct($conn,$input)
{
  // parse_str(file_get_contents("php://input"), $post_vars);
  $product_cd = $input['product_cd'];
  $date_offered = $input['date_offered'];
  $name = $input['name'];
  $product_type_cd = $input['product_type_cd'];

  $sql = "INSERT INTO product (PRODUCT_CD, NAME, PRODUCT_TYPE_CD, DATE_OFFERED) VALUES ('$product_cd', '$name', '$product_type_cd', '$date_offered')";
  if ($conn->query($sql) === TRUE) {
    echo "Nouveau produit créé avec succès";
  } else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
  }
}

// function PUT updateProduct() { ..OK.. }
function updateProduct($conn,$input)
{
  // parse_str(file_get_contents("php://input"), $put_vars);
  $product_cd = $input['product_cd'];
  $name = $input['name'];
  $date_offered = $input['date_offered'];
  $product_type_cd = $input['product_type_cd'];
   // bien "product_type_cd" la khoa chinh cua bang product_type; la duy nhat va la gia tri duoc dinh san, 
  //  do do khi cap nhap gia tri trong bang "product" thi phai chon trong cac gia tri da duoc khai bao o bang "product_type"

  $sql = "UPDATE product SET NAME='$name', DATE_OFFERED='$date_offered',PRODUCT_TYPE_CD='$product_type_cd' WHERE PRODUCT_CD='$product_cd'";
  if ($conn->query($sql) === TRUE) {
    echo "Produit mis à jour avec succès";
  } else {
    echo "Erreur de mise à jour: " . $conn->error;
  }
}

// function DELETE deleteProduct() { ..OK.. }
function deleteProduct($conn, $input)
{
  // parse_str(file_get_contents("php://input"), $delete_vars);
  $product_cd = $input['product_cd'];

  $sql = "DELETE FROM product WHERE PRODUCT_CD='$product_cd'";
  if ($conn->query($sql) === TRUE) {
    echo "Produit supprimé avec succès";
  } else {
    echo "Erreur de suppression: " . $conn->error;
  }
}

$conn->close();
