<?php
/**
 * Employee editing class
 *
 * @author ISK
 */

class employees {
	
	private $employess_table = '';
	private $contracts_table = '';
	
	public function __construct() {
		$this->employess_table = config::DB_PREFIX . 'employees';
		$this->contracts_table = config::DB_PREFIX . 'contracts';
	}
	
	/**
	 * Employee selection
	 * @param type $id
	 * @return type
	 */
	public function getEmployee($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM `{$this->employess_table}`
					WHERE `employee_id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}

    // IF you use auto increment you dont need this function
    public function lastEmployeeID(){
        $query = "SELECT * FROM {$this->brands_table} ORDER BY `employee_id` DESC LIMIT 1";
        mysql::query($query);
        $data = mysql::select($query);
        if(!empty($data)) {
            return $data[0]['employee_id'];
        }
        return 0;
    }


	
	/**
	 * Employee list selection
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getEmplyeesList($limit = null, $offset = null) {
		if($limit) {
			$limit = mysql::escapeFieldForSQL($limit);
		}
		if($offset) {
			$offset = mysql::escapeFieldForSQL($offset);
		}

		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
		}
		if(isset($offset)) {
			$limitOffsetString .= " OFFSET {$offset}";
		}
		
		$query = "  SELECT *
					FROM `{$this->employess_table}`" . $limitOffsetString;
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Employee count calculation
	 * @return type
	 */
	public function getEmplyeesListCount() {
		$query = "  SELECT COUNT(`employee_id`) as `amount`
					FROM `{$this->employess_table}`";
		$data = mysql::select($query);
		
		//
		return $data[0]['amount'];
	}
	
	/**
	 * Employee removal
	 * @param type $id
	 */
	public function deleteEmployee($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM `{$this->employess_table}`
					WHERE `employee_id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Employee update
	 * @param type $data
	 */
	public function updateEmployee($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE `{$this->employess_table}`
					SET    `name`='{$data['name']}',
						   `surname`='{$data['surname']}'
					WHERE `employee_id`='{$data['employee_id']}'";
		mysql::query($query);
	}
	
	/**
	 * Employee insertion
	 * @param type $data
	 */
	public function insertEmployee($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
        print_r($data);

		$query = "  INSERT INTO `{$this->employess_table}`
								(
									`employee_id`,
									`name`,
									`surname`
								) 
								VALUES
								(
									'{$data['employee_id']}',
									'{$data['name']}',
									'{$data['surname']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Amount of contracts the employee is included in selection
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfEmployee($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT(`{$this->contracts_table}`.`number`) AS `amount`
					FROM `{$this->employess_table}`
						INNER JOIN `{$this->contracts_table}`
							ON `{$this->employess_table}`.`employee_id`=`{$this->contracts_table}`.`fk_EMPLOYEEemploee_id`
					WHERE `{$this->employess_table}`.`employee_id`='{$id}'";
		$data = mysql::select($query);
	
		//
		return $data[0]['amount'];
	}
	
}