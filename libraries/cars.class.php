<?php
/**
 * Car editing class
 *
 * @author ISK
 */

class cars {

	private $brands_table = '';
	private $models_table = '';
	private $cars_table = '';
	private $car_states_table = '';
	private $contracts_table = '';
	private $fuel_types_table = '';
	private $car_body_types_table = '';
	private $gear_box_types_table = '';
	private $luggage_table = '';
	
	public function __construct() {
		$this->brands_table = config::DB_PREFIX . 'brands';
		$this->models_table = config::DB_PREFIX . 'models';
		$this->cars_table = config::DB_PREFIX . 'cars';
		$this->car_states_table = config::DB_PREFIX . 'car_states';
		$this->contracts_table = config::DB_PREFIX . 'contracts';
		$this->fuel_types_table = config::DB_PREFIX . 'fuel_types';
		$this->car_body_types_table = config::DB_PREFIX . 'car_body_types';
		$this->gear_box_types_table = config::DB_PREFIX . 'gear_box_types';
		$this->luggage_table = config::DB_PREFIX . 'luggages';
	}
	
	/**
	 * Car selection
	 * @param type $id
	 * @return type
	 */
	public function getCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT `{$this->cars_table}`.`id_CAR`,
						   `{$this->cars_table}`.`state_number`,
						   `{$this->cars_table}`.`manufacturing_date`,
						   `{$this->cars_table}`.`milage`,
						   `{$this->cars_table}`.`radio`,
						   `{$this->cars_table}`.`music_player`,
						   `{$this->cars_table}`.`conditioner`,
						   `{$this->cars_table}`.`number_of_seats`,
						   `{$this->cars_table}`.`registration_date`,
						   `{$this->cars_table}`.`value`,
						   `{$this->cars_table}`.`gear_box`,
						   `{$this->cars_table}`.`fuel_type`,
						   `{$this->cars_table}`.`car_body_type`,
						   `{$this->cars_table}`.`luggage_size`,
						   `{$this->cars_table}`.`state`,
						   `{$this->cars_table}`.`fk_MODELid_MODEL` AS `fk_model`
					FROM `{$this->cars_table}`
					WHERE `{$this->cars_table}`.`id_CAR`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0];
	}

    // IF you use auto increment you dont need this function
    public function lastCarID(){
        $query = "SELECT * FROM {$this->cars_table} ORDER BY `id_CAR` DESC LIMIT 1";
        mysql::query($query);
        $data = mysql::select($query);
        if(!empty($data)) {
            return $data[0]['id_CAR'];
        }
        return 0;
    }
	
	/**
	 * Car update
	 * @param type $data
	 */
	public function updateCar($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE `{$this->cars_table}`
					SET    `state_number`='{$data['state_number']}',
						   `manufacturing_date`='{$data['manufacturing_date']}',
						   `milage`='{$data['milage']}',
						   `radio`='{$data['radio']}',
						   `music_player`='{$data['music_player']}',
						   `conditioner`='{$data['conditioner']}',
						   `number_of_seats`='{$data['number_of_seats']}',
						   `registration_date`='{$data['registration_date']}',
						   `value`='{$data['value']}',
						   `gear_box`='{$data['gear_box']}',
						   `fuel_type`='{$data['fuel_type']}',
						   `car_body_type`='{$data['car_body_type']}',
						   `luggage_size`='{$data['luggage_size']}',
						   `state`='{$data['state']}',
						   `fk_MODELid_MODEL`='{$data['fk_model']}'
					WHERE `id_CAR`='{$data['id_CAR']}'";
		mysql::query($query);
	}

	/**
	 * Car insertion
	 * @param type $data
	 */
	public function insertCar($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

        $nextID = $this->lastCarID()+1;

		$query = "  INSERT INTO `{$this->cars_table}` 
								(
								    `id_CAR`,
									`state_number`,
									`manufacturing_date`,
									`milage`,
									`radio`,
									`music_player`,
									`conditioner`,
									`number_of_seats`,
									`registration_date`,
									`value`,
									`gear_box`,
									`fuel_type`,
									`car_body_type`,
									`luggage_size`,
									`state`,
									`fk_MODELid_MODEL`
								) 
								VALUES
								(
								    '$nextID',
									'{$data['state_number']}',
									'{$data['manufacturing_date']}',
									'{$data['milage']}',
									'{$data['radio']}',
									'{$data['music_player']}',
									'{$data['conditioner']}',
									'{$data['number_of_seats']}',
									'{$data['registration_date']}',
									'{$data['value']}',
									'{$data['gear_box']}',
									'{$data['fuel_type']}',
									'{$data['car_body_type']}',
									'{$data['luggage_size']}',
									'{$data['state']}',
									'{$data['fk_model']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Car list selection
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getCarList($limit = null, $offset = null) {
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
		
		$query = "  SELECT `{$this->cars_table}`.`id_CAR`,
						   `{$this->cars_table}`.`state_number`,
						   `{$this->car_states_table}`.`name` AS `state`,
						   `{$this->models_table}`.`name` AS `model`,
						   `{$this->brands_table}`.`name` AS `brand`
					FROM `{$this->cars_table}`
						LEFT JOIN `{$this->models_table}`
							ON `{$this->cars_table}`.`fk_MODELid_MODEL`=`{$this->models_table}`.`id_MODEL`
						LEFT JOIN `{$this->brands_table}`
							ON `{$this->models_table}`.`fk_BRANDid_BRAND`=`{$this->brands_table}`.`id_BRAND`
						LEFT JOIN `{$this->car_states_table}`
							ON `{$this->cars_table}`.`state`=`{$this->car_states_table}`.`id_CAR_STATE`" . $limitOffsetString;
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Car count calculation
	 * @return type
	 */
	public function getCarListCount() {
		$query = "  SELECT COUNT(`{$this->cars_table}`.`id_CAR`) AS `amount`
					FROM `{$this->cars_table}`
						LEFT JOIN `{$this->models_table}`
							ON `{$this->cars_table}`.`fk_MODELid_MODEL`=`{$this->models_table}`.`id_MODEL`
						LEFT JOIN `{$this->brands_table}`
							ON `{$this->models_table}`.`fk_BRANDid_BRAND`=`{$this->brands_table}`.`id_BRAND`
						LEFT JOIN `{$this->car_states_table}`
							ON `{$this->cars_table}`.`state`=`{$this->car_states_table}`.`id_CAR_STATE`";
		$data = mysql::select($query);
		
		return $data[0]['amount'];
	}
	
	/**
	 * Car removal
	 * @param type $id
	 */
	public function deleteCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM `{$this->cars_table}`
					WHERE `id_CAR`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * amount of contracts for specific car selection
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfCar($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT(`{$this->contracts_table}`.`number`) AS `amount`
					FROM `{$this->cars_table}`
						INNER JOIN `{$this->contracts_table}`
							ON `{$this->cars_table}`.`id_CAR`=`{$this->contracts_table}`.`fk_CARid_CAR`
					WHERE `{$this->cars_table}`.`id_CAR`='{$id}'";
		$data = mysql::select($query);
		
		//
		return $data[0]['amount'];
	}
	
	/**
	 * Pavarų dėžių sąrašo išrinkimas
	 * @return type
	 */
	public function getGearboxList() {
		$query = "  SELECT *
					FROM `{$this->gear_box_types_table}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
	/**
	 * Degalų tipo sąrašo išrinkimas
	 * @return type
	 */
	public function getFuelTypeList() {
		$query = "  SELECT *
					FROM `{$this->fuel_types_table}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Kėbulo tipų sąrašo išrinkimas
	 * @return type
	 */
	public function getBodyTypeList() {
		$query = "  SELECT *
					FROM `{$this->car_body_types_table}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Bagažo tipų sąrašo išrinkimas
	 * @return type
	 */
	public function getLugageTypeList() {
		$query = "  SELECT *
					FROM `{$this->luggage_table}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 * Automobilio būsenų sąrašo išrinkimas
	 * @return type
	 */
	public function getCarStateList() {
		$query = "  SELECT *
					FROM `{$this->car_states_table}`";
		$data = mysql::select($query);
		
		//
		return $data;
	}
	
}