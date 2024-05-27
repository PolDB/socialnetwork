<?php
include_once "PDO.php";

function GetOnePostFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM post WHERE id = $id");
  return $response->fetch();
}

function GetAllPosts()
{
  global $PDO;
  $response = $PDO->query(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "ORDER BY post.created_at DESC"
  );
  return $response->fetchAll();
}

function SearchInPosts($search)
{
  global $PDO;
  $response = $PDO->query(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "WHERE content like '%$search%' "
      . "ORDER BY post.created_at DESC"
  );
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
    return $_SESSION['id'];
  } else {
    return -1;
  }
}

function CreateNewPost($userId, $msg)
{
  global $PDO;
  $sqlQuery = 'INSERT INTO post(user_id, content) values (:user_id, :content)';
  $pdo_prepare = $PDO->prepare($sqlQuery);
  $pdo_prepare->execute([
    ':user_id' => $userId, ':content' => $msg
  ]);
}
