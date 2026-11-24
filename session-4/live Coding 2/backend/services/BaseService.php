<?php

abstract class BaseService
{
    public function checklenght($name)
    {
        if (strlen(trim($name)) < 3) {
            throw new RuntimeException("the name must be upper than 3 ");
        }
    }
}
