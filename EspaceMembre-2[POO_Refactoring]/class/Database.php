<?php 

class Database 
{
       
        /**
         * @var \PDO
        **/
        private $pdo;


     
        /**
         * Constructor Database
         * @param string $login
         * @param string $password
         * @param string $database_name
         * @param string $host
         * 
         * @return void
        */
        public function __construct($login, $password, $database_name, $host = 'localhost')
        {
			$this->pdo = new PDO("mysql:dbname=$database_name;host=localhost", $login, $password);

			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }

        /**
         * Fonction permettant d'executer une requette
         * Vu qu'on aura besoin de faire soit un fetch() ou fetchAll()
         * On va renvoyer simplement la requette 
         * et changer le mode dont on voudra apres
         * 
         * @param string $sql
         * @param bool|array $params
         * 
         * @return PDOStatement
        **/
        public function query($sql, $params = false)
        {
             if($params)
             {
             	$req = $this->pdo->prepare($sql);
	      	    $req->execute($params);

             }else{

                $req = $this->pdo->query($sql);
             }

      	     return $req;
        }


        /**
         * Retourne le dernier id enregistre par PDO
        **/
        public function lastInsertId()
        {
            return $this->pdo->lastInsertId();
        }

}