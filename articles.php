<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission to add a new article
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    $insertQuery = "INSERT INTO articles (titre, contenu, auteur_article, date_creation) 
                    VALUES (:title, :content, :author, NOW())";

    $stmt = $pdo->prepare($insertQuery);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':author', $author);

    $stmt->execute();
}

// Fetch the 10 latest articles
$query = "SELECT * FROM articles ORDER BY date_creation DESC LIMIT 10";
$articles = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Display articles
foreach ($articles as $article) {
    echo "<h2>{$article['titre']}</h2>";
    echo "<p>{$article['contenu']}</p>";
    echo "<p>Author: {$article['auteur_article']}</p>";
    echo "<p>Date: {$article['date_creation']}</p>";
    echo "<a href='commentaires.php?id={$article['id']}'>View Comments</a>";
    echo "<hr>";
}

echo "<h3>Add New Article</h3>";
echo "<form method='post' action='articles.php'>";
echo "<label>Titre: <input type='text' name='title'></label><br>";
echo "<label>Contenu de l'article: <textarea name='content'></textarea></label><br>";
echo "<label>Auteur: <input type='text' name='author'></label><br>";
echo "<input type='submit' value='Envoyer'>";
echo "</form>";
?>
