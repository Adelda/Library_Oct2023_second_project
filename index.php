<?php
include('link.php');
include('linkcss.php');

$query = "SELECT b.id, b.title, a.first_name, a.last_name 
              FROM books b
              JOIN authors a ON b.authors_id = a.id
              ORDER BY b.id";
    $statement = $pdo->query($query);
    $booksAuthors = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <thead>
        <tr>
            <th>ID du livre</th>
            <th>Titre du livre</th>
            <th>Prénom de l'auteur</th>
            <th>Nom de l'auteur</th>
            <th>Modifications</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($booksAuthors as $book) :?>
            <tr>
                <td><?php echo $book['id'];?></td>
                <td><?php echo $book['title'];?></td>
                <td><?php echo $book['first_name'];?></td>
                <td><?php echo $book['last_name'];?></td>
                <td><a href="edit.php?bookid=<?php echo $book['id']; ?>">Modifier</a></td>
                <td><a href="detail.php?bookid=<?php echo $book['id']; ?>">Détails</a></td>
                <td><a href="delete.php?bookid=<?php echo $book['id']; ?>">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="add.php">Ajouter un Livre</a>