<?php
/**
 * Car brand editing class
 *
 * @author ISK
 */

class payments {
	
	private $payments_table = '';
	private $models_table = '';
	
	public function __construct() {
		$this->payments_table = config::DB_PREFIX . 'payments';
		$this->models_table = config::DB_PREFIX . 'models';
	}

    // // IF you use auto increment you dont need this function
    // public function lastBrandID(){
    //     $query = "SELECT * FROM {$this->brands_table} ORDER BY `id_BRAND` DESC LIMIT 1";
    //     mysql::query($query);
    //     $data = mysql::select($query);
    //     if(!empty($data)) {
    //         return $data[0]['id_BRAND'];
    //     }
    //     return 0;
    // }
	
	/**
	 * Brand selection
	 * @param type $id
	 * @return type
	 */
	public function getPayment($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM {$this->payments_table}
					WHERE `id_Payments`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}
	
	/**
	 * Brand list selection
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getPaymentsList($limit = null, $offset = null) {
		if($limit) {
			$limit = mysql::escapeFieldForSQL($limit);
		}
		if($offset) {
			$offset = mysql::escapeFieldForSQL($offset);
		}

		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT *
					FROM {$this->payments_table}{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 *  Brand count calculation
	 * @return type
	 */
	public function getPaymentsListCount() {
		$query = "  SELECT COUNT(`id_Payments`) as `amount`
					FROM {$this->payments_table}";
		$data = mysql::select($query);
		
		// 
		return $data[0]['amount'];
	}
	
	/**
	 * Brand insertion
	 * @param type $data
	 */
	public function insertPayment($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

        // // IF you use auto increment you dont need this part and you should also remove id_BRAND from insert query
        // $brandID = $this->lastBrandID()+1;

		$query = "  INSERT INTO {$this->payments_table}
								(
									`amount`,
									`payment_date`,
									`payment_method`,
									`payment_status`,
									`discount`
								)
								VALUES
								(
									'{$data['amount']}',
									'{$data['payment_date']}',
									'{$data['payment_method']}',
									'{$data['payment_status']}',
									'{$data['discount']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Brand update
	 * @param type $data
	 */
	public function updatePayment($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE {$this->payments_table}
					SET    `amount`='{$data['amount']}',
						   `payment_date`='{$data['payment_date']}',
						   `payment_method`='{$data['payment_method']}',
						   `payment_status`='{$data['payment_status']}',
						   `discount`='{$data['discount']}'
					WHERE `id_Payments`='{$data['id_Payments']}'";
		mysql::query($query);

	}
	
	/**
	 * Brand removal
	 * @param type $id
	 */
	public function deletePayment($id) {
        print_r($id);
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM {$this->brands_table}
					WHERE `id_Payments`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Amount of models for specific brand selection
	 * @param type $id
	 * @return type
	 */
	public function getModelCountOfPayments($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT({$this->models_table}.`id_MODEL`) AS `amount`
					FROM {$this->brands_table}
						INNER JOIN {$this->models_table}
							ON {$this->brands_table}.`id_Payments`={$this->models_table}.`fk_BRANDid_BRAND`
					WHERE {$this->brands_table}.`id_Payments`='{$id}'";
		$data = mysql::select($query);

		return $data[0]['amount'];
	}



	
}