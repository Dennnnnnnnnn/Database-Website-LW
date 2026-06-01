<?php
/**
 * Customer editing class
 *
 * @author ISK
 */

class customers {
	
	private $customers_table = '';
	private $contracts_table = '';

	public function __construct() {
		$this->customers_table = config::DB_PREFIX . 'customers';
		$this->contracts_table = config::DB_PREFIX . 'contracts';
	}
	
	/**
	 * Customer selection
	 * @param type $id
	 * @return type
	 */
	public function getCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM `{$this->customers_table}`
					WHERE `pasport_id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}
	
	/**
	 * Customer list selection
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getCustomersList($limit = null, $offset = null) {
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
					FROM `{$this->customers_table}`" . $limitOffsetString;
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Customer count calculation
	 * @return type
	 */
	public function getCustomersListCount() {
		$query = "  SELECT COUNT(`pasport_id`) as `amount`
					FROM `{$this->customers_table}`";
		$data = mysql::select($query);
		
		//
		return $data[0]['amount'];
	}
	
	/**
	 * Customer removal
	 * @param type $id
	 */
	public function deleteCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM `{$this->customers_table}`
					WHERE `pasport_id`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Customer update
	 * @param type $data
	 */
	public function updateCustomer($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE `{$this->customers_table}`
					SET    `name`='{$data['name']}',
						   `surname`='{$data['surname']}',
						   `birth_date`='{$data['birth_date']}',
						   `phone_number`='{$data['phone_number']}',
						   `email`='{$data['email']}'
					WHERE `pasport_id`='{$data['pasport_id']}'";
		mysql::query($query);
	}
	
	/**
	 * Customer insertion
	 * @param type $data
	 */
	public function insertCustomer($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  INSERT INTO `{$this->customers_table}`
								(
									`pasport_id`,
									`name`,
									`surname`,
									`birth_date`,
									`phone_number`,
									`email`
								) 
								VALUES
								(
									'{$data['pasport_id']}',
									'{$data['name']}',
									'{$data['surname']}',
									'{$data['birth_date']}',
									'{$data['phone_number']}',
									'{$data['email']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Amount of contracts the customer is included in selection
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfCustomer($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT(`{$this->contracts_table}`.`number`) AS `amount`
					FROM `{$this->customers_table}`
						INNER JOIN `{$this->contracts_table}`
							ON `{$this->customers_table}`.`pasport_id`=`{$this->contracts_table}`.`fk_CUSTOMERpasport_id`
					WHERE `{$this->customers_table}`.`pasport_id`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['amount'];
	}
	
}