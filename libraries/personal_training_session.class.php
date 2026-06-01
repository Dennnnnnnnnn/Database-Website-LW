<?php
/**
 * Car brand editing class
 *
 * @author ISK
 */

class persTrainSess {
	
	private $persTrainSess_table = '';
	private $models_table = '';
	
	public function __construct() {
		$this->persTrainSess_table = config::DB_PREFIX . 'personal_training_session'; //write here name of db row
		$this->models_table = config::DB_PREFIX . 'models';
	}

    // IF you use auto increment you dont need this function
    // public function lastBrandID(){
    //     $query = "SELECT * FROM {$this->persTrainSes_table} ORDER BY `id_BRAND` DESC LIMIT 1";
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
	public function getBrand($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM {$this->brands_table}
					WHERE `id_BRAND`='{$id}'";
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
	public function getPersTrainSessList($limit = null, $offset = null) {
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
					FROM {$this->persTrainSess_table}{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 *  Brand count calculation
	 * @return type
	 */
	public function getPersTrainSessListCount() {
		$query = "  SELECT COUNT(`id_Personal_training_session`) as `amount`
					FROM {$this->persTrainSess_table}";
		$data = mysql::select($query);
		
		// 
		return $data[0]['amount'];
	}
	
	/**
	 * Brand insertion
	 * @param type $data
	 */
	public function insertPersTrainSess($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

        // // IF you use auto increment you dont need this part and you should also remove id_BRAND from insert query
        // $brandID = $this->lastBrandID()+1;

		$query = "  INSERT INTO {$this->persTrainSess_table}
								(
									`Date`,
									`Duration`,
									`Calories_burned`, 
									`Feedback`,
									`fk_Attendanceid_Attendance`
								)
								VALUES
								(
									'{$data['date']}',
									'{$data['duration']}',
									'{$data['calories_burned']}',
									'{$data['feedback']}',
									'{$data['fk_Attendanceid_Attendance']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Brand update
	 * @param type $data
	 */
	public function updateBrand($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE {$this->brands_table}
					SET    `name`='{$data['name']}'
					WHERE `id_BRAND`='{$data['id_BRAND']}'";
		mysql::query($query);
	}
	
	/**
	 * Brand removal
	 * @param type $id
	 */
	public function deleteBrand($id) {
        print_r($id);
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM {$this->brands_table}
					WHERE `id_BRAND`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Amount of models for specific brand selection
	 * @param type $id
	 * @return type
	 */
	public function getModelCountOfBrand($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT({$this->models_table}.`id_MODEL`) AS `amount`
					FROM {$this->brands_table}
						INNER JOIN {$this->models_table}
							ON {$this->brands_table}.`id_BRAND`={$this->models_table}.`fk_BRANDid_BRAND`
					WHERE {$this->brands_table}.`id_BRAND`='{$id}'";
		$data = mysql::select($query);

		return $data[0]['amount'];
	}



	
}