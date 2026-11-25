<?php
require_once dirname(__DIR__) . "/config/database.php";

class ThematiqueDao
{
    protected ?PDO $db = null;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db;
    }

    protected function getDB(): PDO
    {
        if ($this->db === null) {
            $this->db = Database::getConnection();
        }
        return $this->db;
    }

    public function getAll()
    {
        $statement = $this->getDB()->query(
            "SELECT id_thematique, Nom_thematique, descreption_thematique FROM thematique"
        );
        $thematiques = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $item) {
            $thematiques[] = new Thematique(
                $item["Nom_thematique"],
                $item["descreption_thematique"] ?? "",
                $item["id_thematique"]
            );
        }
        return $thematiques;
    }

    public function create(Thematique $thematique)
    {
        $statement = $this->getDB()->prepare(
            "INSERT INTO thematique (Nom_thematique, descreption_thematique) VALUES (:name, :description)"
        );
        $statement->execute([
            "name" => $thematique->getName(),
            "description" => $thematique->getDescription()
        ]);
    }
}
