<?php

require "dbconnect.php";

$stmt=$pdo->query('SELECT * FROM Animateur');
$animateurs=$stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt=$pdo->query('SELECT * FROM thematique');
$thematiques=$stmt->fetchAll(PDO::FETCH_ASSOC);


if($_SERVER['REQUEST_METHOD']==="POST"){
    $titre=$_POST['titre'];
    $descreption=$_POST['descreption'];
    $date_publication=$_POST['date_publication'];
    $duree=$_POST['duree'];
    $thematique=$_POST['thematique'];
    $animateur=$_POST['animateur'];
    
try{
    $sqlreq="INSERT INTO episode(titre,descreption_episode,duree_episode,date_publication,id_animateur,id_thematique) VALUES (?,?,?,?,?,?)";
    $stmt=$pdo->prepare($sqlreq);
    $stmt->execute([
        $titre,
        $descreption,
        $duree,
        $date_publication,
        $animateur,
        $thematique


    ]);
    echo "episode added succes";
    header("Location:index.php");
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
    <title>add_page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ADD EPISODE</h1>
    <form action="" method="post" class="form">
        
        <label for="titre">TITRE: </label>
        <input type="text" name="titre" id="titre" required>

        <label for="descreption">descreption</label>
        <input type="text" name="descreption" id="descreption" required>

        <label for="duree">duree(min)</label>
        <input type="number" name="duree" id="duree" required>

        <label for="date_publication">date_publication</label>
        <input type="datetime-local" name="date_publication" id="date_publication" required>

       
        <label for="animateur">animateur</label>
        <select name="animateur" id="animateur">
            <option value="" disabled>choisir un animateur</option>
            <?php foreach ($animateurs as $animateur ): ?>
                <option value="<?= $animateur["id_animateur"]?>"> <?= htmlspecialchars($animateur["nom"] . " " . $animateur["prenom"] )?></option>


              <?php endforeach;?>  
               
            
        </select>

        <label for="thematique">thematique</label>
        <select name="thematique" id="thematique">
            <option value="" disabled>choisir un thematique</option>
            <?php foreach ($thematiques as $thematique ): ?>
                <option value="<?= $thematique["id_thematique"]?>"> <?= htmlspecialchars($thematique["Nom_thematique"]  )?></option>


              <?php endforeach;?>  
               
            
        </select>

        <button type="submit">ajouter</button>




    </form>




    
</body>
</html>