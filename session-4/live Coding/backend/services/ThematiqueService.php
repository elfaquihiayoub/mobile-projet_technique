<?php
require_once __DIR__ . "/../dao/ThematiqueDao.php";
class ThematiqueService{
    private ThematiqueDao $dao;
    public function __construct(ThematiqueDao $thematiqueDao)
    {
        $this->dao=$thematiqueDao;
    }

    public function getAll():array{
        return $this->dao->getAll();
    }
    public function create(Thematique $thematique):void{
        return $this->dao->create($thematique);
    }
}

?>