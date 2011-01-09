<?php

require_once("lib/log4php/Logger.php");

class MysqlManager {

	static private  $_dbServerName = "localhost";
	static private  $_dbUserName = "root";
	static private  $_dbPassword = "07j11b82";
	static private  $_databaseName = "cinedb";

	static private $_isConnected = false;
	
	/**
	 * Ouvre la connexion a la base Mysql
	 * une fois cette fonction appelee, on peut utiliser les fonction
	 * mysql fournits par l'api php, et FINIR par mysql_close();
	 */
	static public function mysqlConnexion(){
		if(self::$_isConnected == false){
			mysql_pconnect(self::$_dbServerName, self::$_dbUserName, self::$_dbPassword);
			@mysql_select_db(self::$_databaseName) or die( "La base demandée n'existe pas");
			mysql_query("SET NAMES 'utf8'") or die("N'arrive pas à positionné l'UTF-8");
			//mysql_query();
			self::$_isConnected = true;
		}
	}

	/**
	 * fonction pour faire un update
	 */
	static public function update($query){
		self::query($query);
	}

	/**
	 * fonction pour exécuter une requète sur le serveur MySQL
	 */
	static public function query($query){
		//connexion à  la base
		self::mysqlConnexion();

		//exécution de la requète
		$result = mysql_query($query);

		//gestion logging
		if($result === false){
			$errMsg = "erreur dans la requète à la base, query : ".$query."<br />".mysql_error(); 
			die($errMsg);
			Logger::getRootLogger()->error($errMsg);			
		}else{
			Logger::getRootLogger()->debug($query);
		}					
			
		return $result;
	}
	
	/**
	 * Exécute une requete de type insert
	 * @param $query la requete
	 * @return le numero de la requete
	 */
	static public function insert($query){
		//connexion a la base
		self::mysqlConnexion();

		$result = self::query($query);
	
		//Récupération de l'id
		$id = mysql_insert_id();
		return $id;

	}

	/**
	 * @deprecated 
	 * Permet d'exécuter une requète de destruction de champs dans la base (utiliser query() directement)  
	 * @param $query requète
	 */
	static public function del($query){
		self::query($query);
	}

	/**
	 * Execute une requete qui renvoie un resultat que sur une seule ligne
	 * Attention si un resultat sur plusieurs ligne est retourne, l'execution
	 * est bloquee.
	 *
	 * @param $query la requete
	 * @return la ligne de resultat
	 */
	static public function getRowResult($query){

		//exécution de la requète
		$result = self::query($query); 

		$nb = mysql_num_rows ($result);
		if($nb > 1){
			die_dme("Erreur dans la requ&egrave;te".$query);
		}
		if($nb == 0){
			return Array();
		}

		$row = mysql_fetch_array($result);

		return $row;
	}

	/**
	 * Execute une requete qui renvoie un tableau
	 *
	 * @param $query la requete
	 * @return le resultat
	 */
	static public function  getResult($query){

		//execution de la requete
		$result = self::query($query);
		
		$return = Array();
		$i = 0;
		while($row = mysql_fetch_array($result)){
			$return[$i] = $row;
			$i++;
		}
		return $return;
	}

	/**
	 * Execute une requete qui renvoie un resultat simple
	 * @param $query la requete
	 * @return le resultat
	 */
	static public function getSimpleResult($query){
		//connexion à la base
		self::mysqlConnexion();

		//exéution de la requète
         $result = self::query($query);


		$row = mysql_fetch_row($result);
		
		if(empty($row)){
			return "";
		}else{
		
			if(count($row) != 1){
				die_dme("La requète renvoie un résultat non suporté");
			}
	
			if(count($row[0]) != 1){
				die_dme("La requète renvoie un résultat non suporté");
			}
			
			return $row[0];
		}
	}

	/**
	 * 
	 * Retourne une tableau sous la forme d'une colonne
	 *
	 * @param unknown_type $query
	 */
	public function getColResult($query){
        
		$result = self::query($query);
		 
		$return = Array();
		$i = 0;
		while($row = mysql_fetch_array($result)){
			if(count($row) != 2){
				die_dme("La requ&egrave;te demand&eacute; : ".$query." ne renvoie pas une simple colonne");
			}
			$return[$i] = $row[0];
			$i++;
		}

		return $return;
	}

	/**
	 * Fonction fermant la connexion a la base, appeler cette fonction
	 * une fois que les acces Ã  la base sont effectuee.
	 */
	static public function closeConnexion(){
		if(self::$_isConnected == true){
			mysql_close();
		}
	}

	/**
	 * Retourne un tableau contenant les différents items du type enum
	 *
	 * @param unknown_type $tableName Nom de la table
	 * @param unknown_type $fieldName Nom du champs
	 */
	static public function getEnumList($tableName, $fieldName){

		$result = self::getRowResult('SHOW COLUMNS FROM '.$tableName." LIKE '".$fieldName."'");
		if(empty($result) == false){
			$enum = $result[1];
			
			$off  = strpos($enum,"(");
			$enum = substr($enum, $off+1, strlen($enum)-$off-2);
			$values = explode(",",$enum);
	 
			$result = array();
			foreach($values as $value){
				//On enlève les '' qui encadre la valeur
				$val = substr($value, 1,strlen($value)-2);

				//au cas où, on remplace les '' par '
				$val = str_replace("''","'",$val);
				$result[] = $val;
			}
			
			return $result;
		}
		return null;
	}

}
?>
