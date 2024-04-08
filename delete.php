<?php

include('link.php');



$id=$_GET['bookid'];



$querybCategory = "DELETE FROM books_categories where books_id=:myId";

$statement = $pdo->prepare($querybCategory);
$statement->bindValue(':myId', $id, \PDO::PARAM_INT);
$statement->execute();

$querybooks = "DELETE FROM books where id=:myId";

$statement = $pdo->prepare($querybooks);
$statement->bindValue(':myId', $id, \PDO::PARAM_INT);
$statement->execute();




header('location:index.php?message=success');
?>
