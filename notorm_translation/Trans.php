<?php

include_once dirname(__FILE__) . '/TransRow.php';
include_once dirname(__FILE__) . '/TransStructure.php';

/**
 * @param PDO $connection
 * @param NotORM_Trans_Structure $structure
 */
class NotORM_Trans extends NotORM {

	public function setRowClass($rowClass) {
		$this->rowClass = $rowClass;
	}

	public function setLanguages($langPrimary, $langSecondary) {
		$this->structure->setLanguages($langPrimary, $langSecondary);
	}

	/**
	 * Insert data into db
	 *
	 * I need to separate data for basic and translation table.
	 * For this reason I need load real database structure.
	 */
	public function insert($table, $data) {
		$basicColumns = $this->structure->getColumns($table);
		$basicData = array_intersect_key($data, $basicColumns);

		$basicRow = $this->$table()->insert($basicData);
		$basicRowIdValue = $basicRow[$this->structure->getPrimary($table)];

		$transTable = $this->structure->getTransTable($table);
		if ($this->structure->tableExists($transTable)) {
			$transColumns = $this->structure->getColumns($transTable);
			$transData = array_intersect_key($data, $transColumns);
			$transData[$this->structure->getTransPrimary($table)] = $basicRowIdValue;
			$transLang = $this->structure->getTransLang();
			if (!array_key_exists($transLang, $transData)) {
				$transData[$transLang] = $this->structure->getLangPrimary();
			}
			$this->$transTable()->insert($transData);
		}
	}


}
