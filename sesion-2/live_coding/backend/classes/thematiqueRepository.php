<?php
require_once "thematique.php";

class ThematiqueRepository{
    private $file;
    public function __construct($file)
    {
        $this->file=$file;
    }

    public function create(Thematique $thematique){
        $data=json_decode(file_get_contents($this->file),true);
        $id=count($data)+1;
        $data[]=[
        "id_thematique"=>$id,
        "nom_thematique"=>$thematique->getNom(),
        "description_thematique"=>$thematique->getDescription(),
        ];
        file_put_contents($this->file,json_encode($data,JSON_PRETTY_PRINT)
    );
        

    return $data;
    }
    public function getAll(){
        $data=json_decode(file_get_contents($this->file),true); 

        $thematiques=[];
        foreach($data as $item){
            $thematiques[]=new Thematique(
                $item["nom_thematique"],
                $item["description_thematique"],
                $item["id_thematique"]
            );

        }
        return $thematiques;

    }
}



?>