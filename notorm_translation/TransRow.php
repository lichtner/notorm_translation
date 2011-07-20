<?php

/**
 * @param Trans_Structure $structure
 * @param NotORM_Result $result
 */
class NotORM_Row_Trans extends NotORM_Row {

	/**
	 * keys are columns from translated table
	 */
	private $trans = array();

	public $transResult;

	function offsetExists($key) {
		if (!isset($this->row[$key])) {
			$table = $this->result->table;
			/* @var $structure Trans_Structure */
			$structure = $this->result->notORM->structure;
			$transTable = $structure->getTransTable($table);
			$transLang = $structure->getTransLang();
			$this->transResult = $this->$transTable($transLang, array($structure->getLangPrimary() , $structure->getLangSecondary()))
						->order($transLang . ' = "' . $structure->getLangSecondary(). '"')->limit(1);
			foreach ($this->transResult as $row) {
				foreach ($row as $key => $val) {
					$this->row[$key] = $val;
					$this->trans[$key] = true;
				}
			}
		}
		return parent::offsetExists($key);
	}

	public function offsetGet($key) {
		$this->offsetExists($key);
		return parent::offsetGet($key);
	}

	public function offsetSet($key, $value) {
		$this->offsetExists($key);
		parent::offsetSet($key, $value);
	}

	protected function access($key, $delete = false) {
		// @todo translated columns are not cached. I don't know how to do this...
		if (isset($this->trans[$key])) {
			return;
		}
		parent::access($key, $delete);
	}

	/** Update row with translations
	 * @param array $data
	 * @return int number of affected rows or false in case of an error
	 */
	public function update($data = null) {
		if (!isset($data)) {
			$data = $this->modified;
		}
		$transFields = array_intersect_key($this->modified, $this->trans);
		if ($transFields) {
			$table = $this->result->table;
			/* @var $structure Trans_Structure */
			$structure = $this->result->notORM->structure;
			$transTable     = $structure->getTransTable($table);
			$transLang      = $structure->getTransLang($table);
			$transPrimary   = $structure->getTransPrimary($table);
			$this->result->notORM->__call($transTable,
					array("$transPrimary = ? AND $transLang = ?", $this[$transPrimary], $structure->getLangPrimary())
				)->update($transFields);
		}
		$basicFields = array_diff_key($this->modified, $this->trans);
		return parent::update($basicFields);
	}

	/** Delete row with all translations
	* @return int number of affected rows or false in case of an error
	*/
	public function delete() {
		/* @var $structure Trans_Structure */
		$table = $this->result->table;
		$structure = $this->result->notORM->structure;
		$transTable = $structure->getTransTable($table);
		$transPrimary = $structure->getTransPrimary($table);
		if ($structure->tableExists($transTable)) {
			$this->result->notORM->__call($transTable,
					array("$transPrimary = ?", $this[$transPrimary])
				)->delete();
		}
		return parent::delete();
	}

}
