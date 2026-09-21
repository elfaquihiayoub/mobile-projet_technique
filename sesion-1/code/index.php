<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <nav>
    <h1>episodes</h1>
    <a href="add._podcast.php">add new episode</a>
    </nav>
    
    

    <?php 
    require "database_connection.php";
    try{
        $sql="SELECT episode.*,Animateur.nom,Animateur.prenom,thematique.Nom_thematique FROM episode 
        JOIN Animateur ON episode.id_animateur = Animateur.id_animateur
        JOIN thematique ON episode.id_thematique = thematique.id_thematique";
    
        $stmt=$pdo->query($sql);
        $episodes=$stmt->fetchAll(PDO::FETCH_ASSOC);


        if(empty($episodes)){
            echo "no episode available ";

        }else{
            echo "<div class='container'>";
            foreach($episodes as $episode){
                echo "<div class='card'>";
                echo "<h2><b>". htmlspecialchars($episode["titre"]) . "</b></h2>";
                echo "<h3><b>". htmlspecialchars($episode["Nom_thematique"]) . "</b></h3>";
                echo "<h3>". htmlspecialchars($episode["nom"]) . "</h3>";
                echo "<h4>". htmlspecialchars($episode["date_publication"]) . "</h4>";
                echo "<h4>". htmlspecialchars($episode["duree_episode"]) . "</h4>";
                echo "<p>". htmlspecialchars($episode["descreption_episode"]) . "</p>";
                echo "</div>";
    
            }
            echo "</div>";
        }
    }catch (PDOException $e){
        echo "Error: " . $e->getMessage();
    }
    
    ?>
</body>
</html>