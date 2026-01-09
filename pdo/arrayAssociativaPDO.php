<?php
class GastoDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getGastoPorData($variavel) {
        $sql = "SELECT a.* FROM tabela WHERE varaivel = :varivael";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':varivael', $variavel);
        $stmt->execute();

        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }
        return $array;
    }
}
?>