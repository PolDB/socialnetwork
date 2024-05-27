<?php
include_once "PDO.php";

function GetOneUserFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user WHERE id = $id");
  return $response->fetch();
}

function GetAllUsers()
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM user ORDER BY nickname ASC");
  return $response->fetchAll();
}

function GetUserIdFromUserAndPassword($username, $password)
{
  global $PDO;

  $sqlQuery = 'SELECT * FROM user WHERE nickname = :nickname';
  $pdo_prepare = $PDO->prepare($sqlQuery);
  $pdo_prepare->execute(['nickname' => $username]);
  $user = $pdo_prepare->fetch();

  if ($user && $_POST['password'] === $user['password']) {
    return $_SESSION['id'] = ['userId'];
  } else {
    return -1;
  }
}
