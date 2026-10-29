<?php 
// class DATA;
    class Thematique{
        private int $id;
        private string $name;
        private string $description;

        public function __construct(string $name, string $description,$id=0){
            $this->id=$id;
            $this->description=$description;
            $this->name=$name; 
        }

        public function getName(){
            return $this->name;
        }
        public function getId(){
            return $this->id;
        }
        public function getDescription(){
            return $this->description;
        }
          public function __toString(): string {
        return "{$this->name} ({$this->description})";
    }

        public function setName( string $name){
            $this->name=$name;
        }
        public function setId(int $id){
            $this->id=$id;
        }
        public function setDescription( string $description){
            $this->description=$description;
        }
    
        
        
        }
?>