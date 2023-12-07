<?php
$pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'username', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM articles ORDER BY date_creation DESC LIMIT 10";
$articles = $pdo->query($sql);

foreach ($articles as $article) {
    echo "<h2>" . htmlspecialchars($article['titre']) . "</h2>";
    echo "<p>" . nl2br(htmlspecialchars($article['contenu'])) . "</p>";
    echo "<a href='commentaires.php?id=" . $article['id'] . "'>Voir les commentaires</a>";
}
?>
 config pour l'init du pdo
 faire une requete preparée
