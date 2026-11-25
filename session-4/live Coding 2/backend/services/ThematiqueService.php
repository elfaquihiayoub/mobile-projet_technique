<?php

require_once __DIR__ . "/../services/BaseService.php";
require_once __DIR__ . "/../models/Thematique.php";
class ThematiqueService extends BaseService
{
    private Thematique $thematique;
    public function __construct(Thematique $thematique)
    {
        $this->thematique = $thematique;
    }
    public function getAll()
    {
        return $this->thematique->getAll();
    }

    public function create(Thematique $thematique)
    {
        $this->checklenght($thematique->getName());
        $this->checkDescription($thematique->getDescription());
        return $this->thematique->create($thematique);
    }


};
