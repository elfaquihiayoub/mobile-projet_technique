<?php

class Thematique
{
    private $id_thematique;
    private $nom_thematique;
    private $description_thematique;

    public function __construct($id_thematique, $nom_thematique, $description_thematique)
    {
        $this->id_thematique = $id_thematique;
        $this->nom_thematique = $nom_thematique;
        $this->description_thematique = $description_thematique;
    }

    public function getId()
    {
        return $this->id_thematique;
    }

    public function getNom()
    {
        return $this->nom_thematique;
    }

    public function getDescription()
    {
        return $this->description_thematique;
    }

    public function setNom($nom_thematique)
    {
        $this->nom_thematique = $nom_thematique;
    }

    public function setDescription($description_thematique)
    {
        $this->description_thematique = $description_thematique;
    }
}


?>