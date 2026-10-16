<?php
class Thematique{
    private  $id;
    private string $name;
    private string $description;

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
    public function setName($name){
        $this->name=$name;
        
    }
    public function setDescreption($description){
        $this->description=$description;

    }



}


?>