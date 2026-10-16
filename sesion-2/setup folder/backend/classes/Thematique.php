<?php

class Thematique {
    private $id;
    private $name;
    private $description;
    
    public function __construct($name,$description,$id=null)
    {
       $this->id=$id;
       $this->name=$name;
       $this->description=$description;

    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getDescreption(){
        return $this->description;
    }
}

?>
