<?php
include('config.php');

$articleId = isset($_GET['id']) ? $_GET['id'] : die('Invalid request');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $author = $_POST['author'];
    $comment = $_POST['comment'];

    $insertQuery = "INSERT INTO commentaires (id_billet, auteur, commentaire, date_commentaire) 
                    VALUES (:id, :author, :comment, NOW())";

    $stmt = $pdo->prepare($insertQuery);
    $stmt->bindParam(':id', $articleId);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':comment', $comment);

    $stmt->execute();
}


$articleQuery = "SELECT * FROM articles WHERE id = :id";
$commentQuery = "SELECT * FROM commentaires WHERE id_billet = :id";

$articleStmt = $pdo->prepare($articleQuery);
$commentStmt = $pdo->prepare($commentQuery);

$articleStmt->bindParam(':id', $articleId);
$commentStmt->bindParam(':id', $articleId);

$articleStmt->execute();
$commentStmt->execute();

$article = $articleStmt->fetch(PDO::FETCH_ASSOC);
$comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);


echo "<h2>{$article['titre']}</h2>";
echo "<p>{$article['contenu']}</p>";
echo "<p>Author: {$article['auteur_article']}</p>";
echo "<p>Date: {$article['date_creation']}</p>";

echo "<h3>Comments</h3>";
foreach ($comments as $comment) {
    echo "<p>{$comment['auteur']} - {$comment['date_commentaire']}</p>";
    echo "<p>{$comment['commentaire']}</p>";
    echo "<hr>";
}

echo "<h3>Add New Comment</h3>";
echo "<form method='post' action='commentaires.php?id={$articleId}'>";
echo "<label>Auteur: <input type='text' name='author'></label><br>";
echo "<label>Commentaire: <textarea name='comment'></textarea></label><br>";
echo "<input type='submit' value='Envoyer'>";
echo "</form>";

echo "<a href='articles.php'>Back to Articles</a>";
?>
