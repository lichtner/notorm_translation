<?php

interface INotORM_Structure_Trans {

	/** Get table with translation for $db->$table()
	* @param string
	* @return string
	*/
	function getTransTable($table);

	/** Get translation table primary key
	* @param string
	* @return string
	*/
	function getTransPrimary($table);

	/** Get translation table language field
	* @return string
	*/
	function getTransLang();


	/** Set primary and secondary language
	* @param char(2)
	* @param char(2)
	*/
	function setLanguages($langPrimary, $langSecondary = '');

	/**
	 * @return char(2)
	 */
	function getLangPrimary();

	/**
	 * @return char(2)
	 */
	function getLangSecondary();

}

/** Structure described by some rules with trans tables
 */
class NotORM_Structure_Trans extends NotORM_Structure_Convention implements INotORM_Structure_Trans {

	private $connection;
	protected $transTable, $transPrimary, $transLang;
	protected $langPrimary, $langSecondary;
	public $db;

	/** Create conventional structure
	* @param string %s stands for table name
	* @param string %1$s stands for key used after ->, %2$s for table name
	* ...etc.
	*/
	function __construct($connection,
				$primary = 'id', $foreign = '%s_id', $table = '%s',
				$transTable = '%s_trans', $transPrimary = '%s_id', $transLang = 'language') {
		parent::__construct($primary, $foreign, $table);
		$this->connection = $connection;
		$this->transTable = $transTable;
		$this->transPrimary = $transPrimary;
		$this->transLang = $transLang;
	}

	public function setLanguages($langPrimary, $langSecondary = '') {
		$this->langPrimary = $langPrimary;
		$this->langSecondary = $langSecondary;
	}

	public function getLangPrimary() {
		return $this->langPrimary;
	}

	public function getLangSecondary() {
		return $this->langSecondary;
	}

	public function getTransTable($table) {
		return sprintf($this->transTable, $table);
	}

	public function getTransPrimary($table) {
		return sprintf($this->transPrimary, $table);
	}

	public function getTransLang() {
		return $this->transLang;
	}

	public function getDb() {
		if (!$this->db) $this->initDatabase();
		return $this->db;
	}

	public function tableExists($table) {
		if (!$this->db) $this->initDatabase();
		return array_key_exists($table, $this->db);
	}

	public function getColumns($table) {
		if (!$this->db) $this->initDatabase();
		return $this->db[$table];
	}

	public function hasTableColumn($table, $column) {
		return isset ($this->db[$table][$column]);
	}


	/**
	 * Get database structure
	 *
	 * this is important only for data inserting because I need to
	 * separate data for basic a translation table
	 *
	 * @todo may be I serialize it?
	 */
	private function initDatabase() {
		$query = "
			SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE FROM information_schema.COLUMNS
			WHERE TABLE_SCHEMA = DATABASE()
		";
		$database = $this->connection->query($query)->fetchAll(PDO::FETCH_GROUP + PDO::FETCH_NUM);
		foreach ($database as $table => $fields) {
			foreach ($fields as $value) {
				$this->db[$table][$value[0]] = $value[1];
			}
		}
	}


}
