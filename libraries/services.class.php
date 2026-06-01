<?php
/**
 * Service editing class
 *
 * @author ISK
 */

class services {
	
	
	private $service_table = '';
	private $contract_table = '';
	private $service_prices_table = '';
	private $selected_services_table = '';

	public function __construct() {
		$this->service_table = config::DB_PREFIX . 'services';
		$this->contract_table = config::DB_PREFIX . 'contracts';
		$this->service_prices_table = config::DB_PREFIX . 'service_prices';
		$this->selected_services_table = config::DB_PREFIX . 'selected_services';
	}
	
	/**
	 * Service list selection
	 * @param type $limit
	 * @param type $offset
	 * @return service list according to specified filters
	 */
	public function getServicesList($limit = null, $offset = null) {
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
					FROM `{$this->service_table}`" . $limitOffsetString;
		$data = mysql::select($query);

		//
		return $data;
	}

    // IF you use auto increment you dont need this function
    public function lastServiceID(){
        $query = "SELECT * FROM {$this->service_table} ORDER BY `id_SERVICE` DESC LIMIT 1";
        mysql::query($query);
        $data = mysql::select($query);
        if(!empty($data)) {
            return $data[0]['id_SERVICE'];
        }
        return 0;
    }
	
	/**
	 * Service count calculation
	 * @return service amount
	 */
	public function getServicesListCount() {
		$query = "  SELECT COUNT(`{$this->service_table}`.`id_SERVICE`) as `amount`
					FROM `{$this->service_table}`";
		$data = mysql::select($query);
		
		//
		return $data[0]['amount'];
	}
	
	/**
	 * Service price list selection
	 * @param type $serviceId
	 * @return service price list
	 */
	public function getServicePrices($serviceId) {
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		
		$query = "  SELECT *
					FROM `{$this->service_prices_table}`
					WHERE `fk_SERVICEid_SERVICE`='{$serviceId}'";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	
	/**
	 * Contracts, which include the service, amount selection
	 * @param type $serviceId
	 * @return contract amount
	 */
	public function getContractCountOfService($serviceId) {
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		
		$query = "  SELECT COUNT(`{$this->contract_table}`.`number`) AS `amount`
					FROM `{$this->service_table}`
						INNER JOIN `{$this->service_prices_table}`
							ON `{$this->service_table}`.`id_SERVICE`=`{$this->service_prices_table}`.`fk_SERVICEid_SERVICE`
						INNER JOIN `{$this->selected_services_table}`
							ON `{$this->service_prices_table}`.`fk_SERVICEid_SERVICE`=`{$this->selected_services_table}`.`fk_ID_SERVICE`
						INNER JOIN `{$this->contract_table}`
							ON `{$this->selected_services_table}`.`fk_CONTRACTnumber`=`{$this->contract_table}`.`number`
					WHERE `{$this->service_table}`.`id_SERVICE`='{$serviceId}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['amount'];
	}
	
	/**
	 * Service selection
	 * @param type $id
	 * @return service data array
	 */
	public function getService($id) {
		$id = mysql::escapeFieldForSQL($id);
		
		$query = "  SELECT *
					FROM `{$this->service_table}`
					WHERE `id_SERVICE`='{$id}'";
		$data = mysql::select($query);

		//
		return $data[0];
	}
	
	/**
	 * Service insertion
	 * @param type $data
	 * @return inserted service ID
	 */
	public function insertService($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

        $nextID = $this->lastServiceID()+1;
		
		$query = "  INSERT INTO `{$this->service_table}`
								(
								    
									`id_SERVICE`,
									`name`,
									`description`
								)
								VALUES
								(
								    '$nextID',
									'{$data['name']}',
									'{$data['description']}'
								)";
		mysql::query($query);
		
		//this for times when you forgot to put auto increment on table
		return $nextID;
        // use this if you have auto increment on your table
		//return mysql::getLastInsertedId();
	}
	
	/**
	 * Service update
	 * @param type $data
	 */
	public function updateService($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
		
		$query = "  UPDATE `{$this->service_table}`
					SET    `name`='{$data['name']}',
						   `description`='{$data['description']}'
					WHERE `id_SERVICE`='{$data['id_SERVICE']}'";
		mysql::query($query);
	}
	
	/**
	 * Service removal
	 * @param type $id
	 */
	public function deleteService($id) {
		$id = mysql::escapeFieldForSQL($id);
		
		$query = "  DELETE FROM `{$this->service_table}`
					WHERE `id_SERVICE`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Service price insertion
	 * @param type $serviceId
	 * @param type $valid_from
	 * @param type $price
	 */
	public function insertServicePrices($serviceId, $valid_from, $price) {
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		$valid_from = mysql::escapeFieldForSQL($valid_from);
		$price = mysql::escapeFieldForSQL($price);
		
		$query = "  INSERT INTO `{$this->service_prices_table}`
								(
									`fk_SERVICEid_SERVICE`,
									`valid_from`,
									`price`
								)
								VALUES
								(
									'{$serviceId}',
									'{$valid_from}',
									'{$price}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Service price removal
	 * @param type $serviceId
	 * @param type $valid_from
	 * @param type $price
	 */
	public function deleteServicePrice($serviceId, $valid_from, $price) {
		$serviceId = mysql::escapeFieldForSQL($serviceId);
		$valid_from = mysql::escapeFieldForSQL($valid_from);
		$price = mysql::escapeFieldForSQL($price);
		
		$query = "  DELETE FROM `{$this->service_prices_table}`
					WHERE `fk_SERVICEid_SERVICE`='{$serviceId}' AND `valid_from`='{$valid_from}' AND `price`='{$price}'";
		mysql::query($query);
	}

	/**
	 * Removal of all service prices
	 * @param type $serviceId
	 * @param type $clause
	 */
	public function deleteAllServicePrices($serviceId) {
		$serviceId = mysql::escapeFieldForSQL($serviceId);

		$query = "  DELETE FROM `{$this->service_prices_table}`
					WHERE `fk_SERVICEid_SERVICE`='{$serviceId}'";
		mysql::query($query);
	}
	
	/**
	 * Ordered service selection
	 * @param type $limit
	 * @param type $offset
	 * @return service list by designated date filters
	 */
	public function getOrderedServices($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);
		
		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->contract_table}`.`contract_date`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->contract_table}`.`contract_date`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->contract_table}`.`contract_date`<='{$dateTo}'";
			}
		}
		
		$query = "  SELECT `id_SERVICE`,
						   `name`,
						   sum(`amount`) AS `service_prices`,
						   sum(`amount`*`{$this->selected_services_table}`.`price`) AS `total`
					FROM `{$this->service_table}`
						INNER JOIN `{$this->selected_services_table}`
							ON `{$this->service_table}`.`id_SERVICE`=`{$this->selected_services_table}`.`fk_ID_SERVICE`
						INNER JOIN `{$this->contract_table}`
							ON `{$this->selected_services_table}`.`fk_CONTRACTnumber`=`{$this->contract_table}`.`number`
					{$whereClauseString}
					GROUP BY `{$this->service_table}`.`id_SERVICE` ORDER BY `total` DESC";
		$data = mysql::select($query);

		//
		return $data;
	}


    public function getOrderedService($contractId, $dateFrom, $serviceId) {
        $contractId = mysql::escapeFieldForSQL($contractId);
        $dateFrom = mysql::escapeFieldForSQL($dateFrom);
        $serviceId = mysql::escapeFieldForSQL($serviceId);

        $query = "SELECT `fk_CONTRACTnumber`,
					  `fk_SERVICE_PRICEvalid_from`,
					  `fk_ID_SERVICE`,
					  `amount`,
					  `price`
				FROM `{$this->selected_services_table}`
				WHERE `fk_CONTRACTnumber`='{$contractId}' AND `fk_SERVICE_PRICEvalid_from`='{$dateFrom}' AND `fk_ID_SERVICE`='{$serviceId}'";
        $data = mysql::select($query);

        //
        return $data[0];
    }


    /**
	 * Ordered service report data selection
	 * @param type $limit
	 * @param type $offset
	 * @return ordered service amount and sum
	 */
	public function getStatsOfOrderedServices($dateFrom, $dateTo) {
		$dateFrom = mysql::escapeFieldForSQL($dateFrom);
		$dateTo = mysql::escapeFieldForSQL($dateTo);
		
		$whereClauseString = "";
		if(!empty($dateFrom)) {
			$whereClauseString .= " WHERE `{$this->contract_table}`.`contract_date`>='{$dateFrom}'";
			if(!empty($dateTo)) {
				$whereClauseString .= " AND `{$this->contract_table}`.`contract_date`<='{$dateTo}'";
			}
		} else {
			if(!empty($dateTo)) {
				$whereClauseString .= " WHERE `{$this->contract_table}`.`contract_date`<='{$dateTo}'";
			}
		}
		
		$query = "  SELECT sum(`amount`) AS `service_prices`,
						   sum(`amount`*`{$this->selected_services_table}`.`price`) AS `total`
					FROM `{$this->service_table}`
						INNER JOIN `{$this->selected_services_table}`
							ON `{$this->service_table}`.`id_SERVICE`=`{$this->selected_services_table}`.`fk_ID_SERVICE`
						INNER JOIN `{$this->contract_table}`
							ON `{$this->selected_services_table}`.`fk_CONTRACTnumber`=`{$this->contract_table}`.`number`
					{$whereClauseString}";
		$data = mysql::select($query);

		//
		return $data;
	}
}