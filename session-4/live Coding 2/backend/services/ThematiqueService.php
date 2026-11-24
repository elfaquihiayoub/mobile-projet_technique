<?php

require_once __DIR__ . "/../services/BaseService.php";
require_once __DIR__ . "/../dao/ThematiqueDao.php";
class ThematiqueService extends BaseService
{
    private ThematiqueDao $dao;
    public function __construct(ThematiqueDao $thematiqueDao)
    {
        $this->dao = $thematiqueDao;
    }
    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function create(Thematique $thematique)
    {
        $this->checklenght($thematique->getName());
        $this->checkDescription($thematique->getDescription());
        return $this->dao->create($thematique);
    }


};
