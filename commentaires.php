<?php
$pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'username', 'password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = $_GET['id'];

    $sql = "SELECT * FROM articles WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$article_id]);
    $article = $stmt->fetch();

    $sql = "SELECT * FROM commentaires WHERE id_billet = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$article_id]);
    $commentaires = $stmt->fetchAll();
    
    $stmt = $_COOKI
    echo "<h2>" . htmlspecialchars($article['titre']) . "</h2>";
    echo "<p>" . nl2br(htmlspecialchars($article['contenu'])) . "</p>";

    echo "<h3>Commentaires:</h3>";
    foreach ($commentaires as $commentaire) {
        echo "<p>" . nl2br(htmlspecialchars($commentaire['commentaire'])) . "</p>";
    }
} else {
    echo "Article non trouvé.";
}
?>
