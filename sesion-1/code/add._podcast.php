<?php
require "database_connection.php";
$animateurs=$pdo->query("SELECT * FROM animateur")->fetchAll(PDO::FETCH_ASSOC);
$thematiques = $pdo->query("SELECT * FROM thematique")->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD']==="POST"){
    $titre=$_POST["titre"];
    $descreption=$_POST["descreption"];
    $date_publication=$_POST["date_publication"];
    $duree=$_POST["duree"];
    $id_thematique=$_POST["id_thematique"];
    $id_animateur=$_POST["id_animateur"];
    try{
        $sqlrequete="INSERT INTO episode(titre,descreption_episode,date_publication,duree_episode,id_thematique,id_animateur)VALUES(?, ?, ?, ?, ?, ?)";
        $stmt=$pdo->prepare($sqlrequete);
        $stmt->execute([
            $titre,
            $descreption,
            $date_publication,
            $duree,
            $id_thematique,
            $id_animateur]
    
        );
        echo "Episode added successfully!";
        header("Location: code\index.php");
        exit;
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }

   
    
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD episode</title>
</head>
<body>
    <div class="container">
        <h1>add episode</h1>
        <form action="" method="POST">
            <label for="titre">TITRE :</label>
            <input type="text" id="titre" name="titre" required>

            <label for="descreption">descreption :</label>
            <textarea name="descreption" required></textarea>
            <br>

            <label for="date_publication">date publication :</label>
            <input type="datetime-local" id="date_publication" name="date_publication" required>
            <br>
            <label for="duree">duree(min) :</label>
            <input type="number" id="duree" name="duree" required>
            <br>

            <select name="id_thematique" id="id_thematique">
                <option value="" disabled>choisir un thematique</option>
                <!-- looping through the collected data from ur table thematique -->
                <?php foreach($thematiques as $thematique): ?>
                <option value=" <?=$thematique["id_thematique"]?>"><?= htmlspecialchars($thematique["Nom_thematique"])?> </option>
                <?php endforeach; ?>
            </select>
            <br>
            <select name="id_animateur" id="id_animateur">
                <option value="" disabled>choisir un animateur</option>
                <!-- looping through the collected data from ur table animateur -->
                <?php foreach($animateurs as $animateur): ?>
                <option value=" <?=$animateur["id_animateur"]?>"><?= htmlspecialchars($animateur['nom']. "". $animateur["prenom"])?> </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Ajouter</button> 
            </form>

    
    </div>

    
</body>
</html>
