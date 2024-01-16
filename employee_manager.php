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



// function GET readEmployees() { ..OK.. }
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


// function POST createEmployee() { .OK.. }
function createEmployee($conn, $input)
{
  $first_name = $input['first_name'];
  $last_name = $input['last_name'];
  $start_date = $input['start_date'];
  $title = $input['title'];
  $assigned_branch_id = $input['assigned_branch_id'];
  $dept_id = $input['dept_id'];
  $superior_emp_id = $input['superior_emp_id'];

  $sql = "INSERT INTO employee (FIRST_NAME, LAST_NAME, START_DATE, TITLE, ASSIGNED_BRANCH_ID, DEPT_ID, SUPERIOR_EMP_ID) VALUES ('$first_name', '$last_name', '$start_date', '$title', '$assigned_branch_id', '$dept_id', '$superior_emp_id')";
   if ($conn->query($sql) === TRUE) {
    echo "Nouvel employé créé avec succès";
  } else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
  }
}


// function PUT updateEmployee() { ..OK.. }
function updateEmployee($conn, $data)
{
  $emp_id = $data['emp_id'];
  $first_name = $data['first_name'];
  $last_name = $data['last_name'];
  $START_DATE = $data['START_DATE'];
  $TITLE = $data['TITLE'];
  $ASSIGNED_BRANCH_ID = $data['ASSIGNED_BRANCH_ID'];
  $DEPT_ID = $data['DEPT_ID'];
  $SUPERIOR_EMP_ID = $data['SUPERIOR_EMP_ID'];
  // Ajouter d'autres champs ici si nécessaire (da lam ok)
  $sql = "UPDATE employee SET FIRST_NAME='$first_name', LAST_NAME='$last_name',  START_DATE ='$START_DATE', TITLE='$TITLE', ASSIGNED_BRANCH_ID='$ASSIGNED_BRANCH_ID' , DEPT_ID='$DEPT_ID' , SUPERIOR_EMP_ID='$SUPERIOR_EMP_ID' WHERE EMP_ID='$emp_id'";
  if ($conn->query($sql) === TRUE) {
    echo "Employé mis à jour avec succès";
  } else {
    echo "Erreur de mise à jour: " . $conn->error;
  }
}


// function DELETE deleteEmployee() { ..OK. }
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
