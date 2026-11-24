<?php

abstract class BaseService
{
    public function checklenght($name)
    {
        if (strlen(trim($name)) < 3) {
            throw new RuntimeException("the name must be upper than 3 ");
        }
        if(strlen(trim($name)) > 10){
            throw new RuntimeException("the name must be lower than 10 ");
        }
    }
    public function checkDescription($description)
    {
        if (strlen(trim($description)) < 10) {
            throw new RuntimeException("the description must be upper than 10 ");
        }
        if(strlen(trim($description)) > 100){
            throw new RuntimeException("the description must be lower than 100 ");
        }
    }
}
