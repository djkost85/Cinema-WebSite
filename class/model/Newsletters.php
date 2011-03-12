<?php
	require_once("class/sql/DbField.php");

	class Newsletters extends DbField {
		
		/// objet de la newsletter
		private $object;

		/// contenu
		private $contents;
		
		///date de l'envoie
		private $date;
		
		///type de l'envoie
		private $sendType;
		
		public function __construct($id = 0, $object ='', $contents='', $date='', $sendType=''){
			
			parent::__construct("Newsletters", $id);
			
			$this->object = $object;
			
			$this->contents = $contents;
			
			$this->date = $date;
			
			$this->sendType = $sendType;
			
		}
		
		/**GETTER / SETTER**/
		public function getObject(){
			return $this->object;
		}
		
		public function setObject($object){
			$this->object = $object;
		}
		
		public function getContents(){
			return $this->contents;
		}
		
		public function setContents($contents){
			$this->contents = $contents;
		}		
		
		
		/**
		 * Stocke les nouvelles données dans la base de donnée
		 */
		function storeInDb(){
			//On stocke la newsletters
			$fields = array(	$this->object => new DbEntry("object", "string"), 
								$this->contents => new DbEntry("contents","string"),
								$this->date => new DbEntry("date", "date"),
								$this->sendType => new DbEntry("sendType", "string")
			);
	
			parent::makeStoreRequest($fields);
		}
		
	}

?>