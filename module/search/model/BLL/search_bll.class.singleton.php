<?php
  require ('module/home/model/DAO/search_dao.class.singleton.php');

	class search_bll {
		private $dao;
		private $db;
		static $_instance;

		function __construct() {
			$this -> dao = search_dao::getInstance();
			$this -> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_load_operations_BLL() {
			return $this -> dao -> select_load_operations($this -> db);
		}

		 public function get_load_category_BLL() {
		 	return $this -> dao -> select_load_category($this -> db, $_POST['operation']);
		 }

		 public function get_load_category_null_BLL() {
		 	return $this -> dao -> select_load_category_null($this -> db);
		 }

		public function get_autocomplete_BLL() {
			try {
   
            if (!empty($_POST['operation']) && empty($_POST['category'])) {//si operation no esta vacio y category si
                return $this -> dao -> select_only_operation($this -> db, $_POST['complete'], $_POST['operation']);
            } else if (empty($_POST['operation']) && !empty($_POST['category'])) {//si operation esta vacio y category no esta vacio
               	return $this -> dao -> select_only_category($this -> db, $_POST['category'], $_POST['complete']);
            } else if (!empty($_POST['operation']) && !empty($_POST['category'])) {//si operation no esta vacio y category no esta vacio
				return $this -> dao -> select_operation_category($this -> db, $_POST['complete'], $_POST['operation'], $_POST['category']);
            } else {
                return $this -> dao -> select_city($this -> db, $_POST['complete']);
            }
        	} catch (Exception $e) {
            echo json_encode("catch");
            exit;
        }
		}
	}
	
?>