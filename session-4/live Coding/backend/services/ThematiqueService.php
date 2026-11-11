<?php
require_once __DIR__ . "/../dao/ThematiqueDao.php";
require_once __DIR__ . "/./BaseService.php";

class ThematiqueService extends BaseService
{
    private ThematiqueDao $dao;
    public function __construct(ThematiqueDao $thematiqueDao)
    {
        $this->dao = $thematiqueDao;
    }
    public function getAll(): array
    {
        return $this->dao->getAll();
    }
    public function create(Thematique $thematique): void
    {
        $this->dao->create($thematique);
    }
}
