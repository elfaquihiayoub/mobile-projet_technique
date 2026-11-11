<?php
class Thematique{
    private int $id;
    private string $name;
    private string $description;

    public function __construct(string $name,string $description,$id=0)
    {
        $this->id=$id;
        $this->name=$name;
        $this->description=$description;

    }


    public function getName(){
        return $this->name;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getId(){
        return $this->id;
    }

    public function setName(string $name){
        $this->name=$name;

    }
    public function setDescription(string $description){
        $this->description=$description;

    }
 



}


?>