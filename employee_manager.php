<?php
include 'db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
  case 'POST':
    createEmployee($conn, $input);
    break;
  case 'GET':
    readEmployees($conn);
    break;
  case 'PUT':
    updateEmployee($conn, $input);
    break;
  case 'DELETE':
    deleteEmployee($conn, $input);
    break;
}

function createEmployee($conn, $data)
{
  $first_name = $data['first_name'];
  $last_name = $data['last_name'];
  $start_date = $data['start_date'];
  $end_date = $data['end_date'];
  $title = $data['title'];
  $assigned_branch_id = $data['assigned_branch_id'];
  $dept_id = $data['dept_id'];
  $superior_emp_id = $data['superior_emp_id'];

  $sql = "INSERT INTO employee (FIRST_NAME, LAST_NAME, START_DATE, END_DATE, TITLE, ASSIGNED_BRANCH_ID, DEPT_ID, SUPERIOR_EMP_ID) VALUES ('$first_name', '$last_name', '$start_date', '$end_date', '$title', '$assigned_branch_id', '$dept_id', '$superior_emp_id')";

  if ($conn->query($sql) === TRUE) {
    echo "Nouvel employé créé avec succès";
  } else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
  }
}

function readEmployees($conn)
{
  $sql = "SELECT * FROM employee";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "ID: " . $row["EMP_ID"] . " - Nom: " . $row["FIRST_NAME"] . " " . $row["LAST_NAME"] . "<br>";
    }
  } else {
    echo "0 résultat";
  }
}

function updateEmployee($conn, $data)
{
  $emp_id = $data['emp_id'];
  $first_name = $data['first_name'];
  $last_name = $data['last_name'];
  // Ajouter d'autres champs ici si nécessaire

  $sql = "UPDATE employee SET FIRST_NAME='$first_name', LAST_NAME='$last_name' WHERE EMP_ID='$emp_id'";
  if ($conn->query($sql) === TRUE) {
    echo "Employé mis à jour avec succès";
  } else {
    echo "Erreur de mise à jour: " . $conn->error;
  }
}

function deleteEmployee($conn, $data)
{
  $emp_id = $data['emp_id'];

  $sql = "DELETE FROM employee WHERE EMP_ID='$emp_id'";
  if ($conn->query($sql) === TRUE) {
    echo "Employé supprimé avec succès";
  } else {
    echo "Erreur de suppression: " . $conn->error;
  }
}

$conn->close();
