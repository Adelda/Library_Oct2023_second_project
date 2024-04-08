<?php

include('link.php');
include('linkcss.php');

if (!empty($_POST)) {
    $title = $_POST['title'];
    $release =  $_POST['release_date'];
    $isbn = $_POST['isbn'];
    $authors_id = $_POST['authors_id'];
    $category = $_POST['category_name'];
    $bookSummary = $_POST['book_summary'];
    

    $pdo->query("INSERT INTO books (title, release_date, isbn, authors_id, book_summary) VALUES ('$title', '$release', $isbn, $authors_id, '$bookSummary')");
    $id_book = $pdo->lastInsertId();

    $pdo->query("INSERT INTO books_categories (books_id) VALUES ($id_book)");
   
    
    header('Location: index.php');
    die;
}


$queryAuthors = "SELECT * FROM authors";
$statement = $pdo->query($queryAuthors);
$booksAuthors = $statement->fetchAll(PDO::FETCH_ASSOC);

$queryCategories = "SELECT * FROM categories";
$statement = $pdo->query($queryCategories);
$booksCategories = $statement->fetchAll(PDO::FETCH_ASSOC);




echo '<form method="post">';
echo '<table>';
echo '<tr><th>Titre</th><td><input type="text" name="title" value=""/></td></tr>';
echo '<tr><th>Date de sortie</th><td><input type="date" name="release_date" value=""/></td></tr>';
echo '<tr><th>Numéro ISBN</th><td><input type="text" name="isbn" value=""/></td></tr>';
echo '<tr><th>Description</th><td><textarea name="book_summary"></textarea></td></tr>';
echo '<tr><th>Auteur</th><td><select name="authors_id"><option value="">--Veuillez choisir une option--</option>';

foreach ($booksAuthors as $author) {
    echo "<option value=" . $author['id'] . ">". $author['last_name'] . " " . $author['first_name'] .   "</option>";
}

echo '<tr><th>Categories</th><td><select name="category_name"><option value="">--Veuillez choisir une option--</option>';

foreach ($booksCategories as $category) {
    echo "<option value=" . $category['id'] . ">". $category['name'] . "</option>";
}

echo '</select></td></tr>';
echo '<tr><td><input type="submit" value="Enregistrer"></td></tr>';
echo '</table>';
echo '</form>';

?>



