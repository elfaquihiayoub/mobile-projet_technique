<?php
require_once __DIR__ . "/Thematique.php";
require_once __DIR__ . "/BaseService.php";
require_once __DIR__ . "/ThematiqueDAO.php";

class GestionThematique extends BaseService
{
    private ThematiqueDAO $thematiqueDAO;

    public function __construct(ThematiqueDAO $thematiqueDAO)
    {
        $this->thematiqueDAO = $thematiqueDAO;
    }

    public function getAll(): array
    {
        return $this->thematiqueDAO->findAll();
    }

    public function create(Thematique $thematique): Thematique
    {
        $name = $this->normalizeAndValidateText($thematique->getName(), "nom", 3);
        $thematique->setName($name);

        return $this->thematiqueDAO->create($thematique);
    }
}
