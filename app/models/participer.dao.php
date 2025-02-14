<?php 
//inclure la classe validator
require_once '../app/controllers/validator.class.php';

class ParticiperDAO
{
    private ?PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    public function setPdo(PDO $pdo): void {
        $this->pdo = $pdo;
    }

    /**
     * @brief Fonction permettant d'hydrater un tableau de données en objets Token
     * @details Cette fonction permet d'hydrater un tableau de données en objets Token
     * @param array $tab
     * @return array
     */
    public function hydrate(array $tab): ?Participer {
        $participer = new Participer();
        $participer->setEvtId($tab['evtId']);
        $participer->setUserId($tab['userId']);
        if(is_string($tab['dateInscr'])) {
            $tab['dateInscr'] = new DateTime($tab['dateInscr']);
            $participer->setDateInscr($tab['dateInscr']);
        }
        return $participer;
    }

        /**
     * @brief Fonction permettant d'hydrater un tableau de données en objets Token
     * @details Cette fonction permet d'hydrater un tableau de données en objets Token
     * @param array $tab
     * @return array
     */
    public function hydrateAll(array $tab): array {
        $participer = [];
        foreach ($tab as $participer) {
            $participer[] = $this->hydrate($participer);
        }
        return $participer;
    }


    /**
     * @brief Fonction permettant de récupérer un token en base de données en fonction de son id
     * @details Cette fonction permet de récupérer un token en base de données en fonction de son id
     * @param int $id
     * @return Token|null
     */
    public function find(?int $id): ?Participer {
        $sql = "SELECT * FROM gk_participer WHERE userId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $participerTab = $pdoStatement->fetch();
        $participer = $this->hydrate($participerTab);
        return $participer;
    }

        /**
     * @brief Fonction permettant de récupérer un token en base de données en fonction de son id
     * @details Cette fonction permet de récupérer un token en base de données en fonction de son id
     * @param int $id
     * @return Token|null
     */
    public function findEvt(?int $evtId): ?Participer {
        $sql = "SELECT * FROM gk_participer WHERE evtId = :evtId";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':evtId' => $evtId));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $participerTab = $pdoStatement->fetch();
        $participer = $this->hydrate($participerTab);
        return $participer;
    }

        /**
     * @brief Fonction permettant de récupérer un token en base de données en fonction de son id
     * @details Cette fonction permet de récupérer un token en base de données en fonction de son id
     * @param int $id
     * @return Token|null
     */
    public function findUserEvt(?int $userId, ?int $evtId): ?Participer {
        $sql = "SELECT * FROM gk_participer WHERE userId = :userId AND evtId = :evtId";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':userId' => $userId, ':evtId' => $evtId));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $participerTab = $pdoStatement->fetch();
        if($participerTab == false) {
            return null;
        }else{
            $participer = $this->hydrate($participerTab);
            return $participer;
        }        
    }

    // fonction permettant de trouver tous les evenements auxquels participer l'utilisateur 
    public function findAllUserEvt(?int $userId): ?array {
        $sql = "SELECT * FROM gk_participer WHERE userId = :userId";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':userId' => $userId));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $participerTab = $pdoStatement->fetchAll();
        if($participerTab == false) {
            return null;
        }else{
            $participer = $this->hydrateAll($participerTab);
            return $participer;
        }   
    }

    /**
     * @brief Fonction permettant de récupérer tout les token en base de données
     * @details Cette fonction permet de récupérer tout les token en base de données
     * @return Token|null
     */
    public function findAll() {
        $sql = "SELECT * FROM gk_participer";
        $pdoStatement = $this->pdo->query($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $participerTab = $pdoStatement->fetchAll();
        $participer = $this->hydrateAll($participerTab);
        return $participer;
    }

    public function insert(Participer $participer): void
    {
        $sql = "INSERT INTO gk_participer(userId, evtId, dateInscr) VALUES (:userId, :evtId, :dateInscr)";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            ':userId' => $participer->getUserId(),
            ':evtId' => $participer->getEvtId(),
            ':dateInscr' => $participer->getDateInscr()->format('Y-m-d H:i:s'),
        ]);
    }

        /**
     * @brief Fonction permettant de supprimer un token en base de données
     * @details Cette fonction permet de supprimer un token en base de données en fonction de son identifiant
     * @param Token $token
     * @return void
     */
    public function delete(Participer $participer): void {
        $sql = "DELETE FROM gk_participer WHERE userId = :userId AND evtId = :evtId";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            ':userId' => $participer->getUserId(),
            ':evtId' => $participer->getEvtId(),
        ]);
    }
    


    
}