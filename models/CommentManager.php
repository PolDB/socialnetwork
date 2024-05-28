<?php
include_once "PDO.php";

function GetOneCommentFromId($id)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM comment WHERE id = :id ");
  $response->execute(
    array(
      "id" => $id
    )
  );
  return $response->fetch();
}

function GetAllComments()
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM comment ORDER BY created_at ASC");
  $response->execute();
  return $response->fetchAll();
}

function GetAllCommentsFromUserId($postId)
{
  global $PDO;
  $response = $PDO->prepare(
    "SELECT comment.*, user.nickname "
      . "FROM comment LEFT JOIN user on (comment.user_id = user.id) "
      . "WHERE comment.user_id = :postId "
      . "ORDER BY comment.created_at ASC"
  );
  $response->execute([':postId' => $postId]);
  return $response->fetchAll();
}

function CreateNewComment($userId, $postId, $comment)
{
  global $PDO;
  $response = $PDO->prepare(
    "INSERT INTO comment(user_id, post_id, content) values (:userId, :postId, :comment)"

  );
  $response->execute([':userId' => $userId, ':postId' => $postId, ':comment' => $comment]);
  return $response->fetchAll();
}
