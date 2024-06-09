<?php
require('module/profile/model/DAO/profile_dao.class.singleton.php');

class profile_bll
{
	private $dao;
	private $db;
	static $_instance;

	function __construct()
	{
		$this->dao = profile_dao::getInstance();
		$this->db = db::getInstance();
	}

	public static function getInstance()
	{
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function get_lista_facturas_BLL($args)
	{
		//return ($args); // funciona
		return $this->dao->lista_facturas($this->db, $args);
	}
}