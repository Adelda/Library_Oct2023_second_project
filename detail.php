<?php

include('link.php');


$id = $_GET['bookid'];


$queryBooks = "SELECT b.id, b.title, b.isbn, b.release_date, b.book_summary, a.first_name, a.last_name, c.name as category_name
               FROM books b
               JOIN authors a ON b.authors_id = a.id
               LEFT JOIN books_categories bc ON b.id = bc.books_id
               LEFT JOIN categories c ON bc.categories_id = c.id
               WHERE b.id = :myId";
$statementBooks = $pdo->prepare($queryBooks);
$statementBooks->bindValue(':myId', $id, \PDO::PARAM_INT);
$statementBooks->execute();
$book = $statementBooks->fetch(PDO::FETCH_ASSOC);


echo "ID : " . $book['id'] . "<br>".
     "Titre :  " . $book['title'] . "<br>".
     "ISBN :  " . $book['isbn'] . "<br>".
     "Date de sortie :" . $book['release_date'] . "<br>" .
     "Description:" .$book['book_summary'] . "<br>";

echo "Auteur : " . $book['first_name'] . " " . $book['last_name'] . "<br>";

echo "Catégorie : " . $book['category_name'] . "<br>";


