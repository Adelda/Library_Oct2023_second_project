<?php

include('link.php');


if (!empty($_GET['bookid'])) {
    $id_book = $_GET['bookid'];

    
    $queryBook = "SELECT b.id, b.title, b.isbn, b.release_date, b.book_summary, a.id as author_id, a.first_name, a.last_name, c.id as category_id, c.name as category_name
                  FROM books b
                  JOIN authors a ON b.authors_id = a.id
                  LEFT JOIN books_categories bc ON b.id = bc.books_id
                  LEFT JOIN categories c ON bc.categories_id = c.id
                  WHERE b.id = :myId";
    $stmt = $pdo->prepare($queryBook);
    $stmt->bindParam(':myId', $id_book, PDO::PARAM_INT);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        echo "Livre non trouvé.";
        exit;
    }

    if (!empty($_POST)) {
        
        $newTitle = $_POST['newTitle'];
        $newReleaseDate = $_POST['newReleaseDate'];
        $newISBN = $_POST['newISBN'];
        $newBookSummary = $_POST['newBookSummary'];
        $newAuthorID = $_POST['authors_id'];
        $newCategoryID = $_POST['category_name'];

        $queryUpdateBook = "UPDATE books
                            SET title = :newTitle,
                                release_date = :newReleaseDate,
                                isbn = :newISBN,
                                book_summary = :newBookSummary,
                                authors_id = :newAuthorID
                            WHERE id = :id_book";
        $stmtUpdate = $pdo->prepare($queryUpdateBook);
        $stmtUpdate->bindParam(':newTitle', $newTitle);
        $stmtUpdate->bindParam(':newReleaseDate', $newReleaseDate);
        $stmtUpdate->bindParam(':newISBN', $newISBN);
        $stmtUpdate->bindParam(':newBookSummary', $newBookSummary);
        $stmtUpdate->bindParam(':newAuthorID', $newAuthorID, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id_book', $id_book, PDO::PARAM_INT);
        $stmtUpdate->execute();

        
        $queryUpdateCategory = "UPDATE books_categories
                                SET categories_id = :newCategoryID
                                WHERE books_id = :id_book";
        $stmtUpdateCategory = $pdo->prepare($queryUpdateCategory);
        $stmtUpdateCategory->bindParam(':newCategoryID', $newCategoryID, PDO::PARAM_INT);
        $stmtUpdateCategory->bindParam(':id_book', $id_book, PDO::PARAM_INT);
        $stmtUpdateCategory->execute();

        
        header('Location: index.php');
        exit;
    }

    $queryAuthors = "SELECT * FROM authors";
    $statementAuthors = $pdo->query($queryAuthors);
    $authors = $statementAuthors->fetchAll(PDO::FETCH_ASSOC);

    $queryCategories = "SELECT * FROM categories";
    $statementCategories = $pdo->query($queryCategories);
    $categories = $statementCategories->fetchAll(PDO::FETCH_ASSOC);

    
    echo '<form method="post">';
    echo '<table>';
    echo '<tr><th>Titre</th><td><input type="text" name="newTitle" value="' . $book['title'] . '"/></td></tr>';
    echo '<tr><th>Date de sortie</th><td><input type="date" name="newReleaseDate" value="' . $book['release_date'] . '"/></td></tr>';
    echo '<tr><th>Numéro ISBN</th><td><input type="text" name="newISBN" value="' . $book['isbn'] . '"/></td></tr>';
    echo '<tr><th>Description</th><td><textarea name="newBookSummary">' . $book['book_summary'] . '</textarea></td></tr>';
    
    echo '<tr><th>Auteur</th><td><select name="authors_id">';
    foreach ($authors as $author) {
        $selected = ($author['id'] == $book['author_id']) ? 'selected' : '';
        echo "<option value='" . $author['id'] . "' $selected>" . $author['last_name'] . ' ' . $author['first_name'] . "</option>";
    }
    echo '</select></td></tr>';
    
    echo '<tr><th>Categories</th><td><select name="category_name" multiple>';
    foreach ($categories as $category) {
        $selected = ($category['id'] == $book['category_id']) ? 'selected' : '';
        echo "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
    }
    echo '</select></td></tr>';
    
    echo '<tr><td><input type="submit" value="Enregistrer"></td></tr>';
    echo '</table>';
    echo '</form>';
} else {
    echo "ID du livre non spécifié.";
}
?>
