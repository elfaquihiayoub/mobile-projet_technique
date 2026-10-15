<?php
    class Categorie{

    private int $id ;
    private string $name ;
    private string $descreption ;

    public function   __construct($id,$name,$descreption)
    {
        $this->id=$id;
        $this->name=$name;
        $this->id=$descreption;

    }

    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getDescreption(){
        return $this->descreption;
    }

    public function setName($name){
        $this->name=$name;

    }
    public function setDescreption($descreption){
        $this->descreption=$descreption;

    }




    }


?>
