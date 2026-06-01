<?php
/**
 * Car model editing class
 *
 * @author ISK
 */

class models {
	
	private $brands_table= '';
	private $models_table = '';
	private $cars_table = '';
	
	public function __construct() {
		$this->brands_table = config::DB_PREFIX . 'brands';
		$this->models_table = config::DB_PREFIX . 'models';
		$this->cars_table = config::DB_PREFIX . 'cars';
	}

    public function lastModelID(){
        $query = "SELECT * FROM {$this->models_table} ORDER BY `id_MODEL` DESC LIMIT 1";
        mysql::query($query);
        $data = mysql::select($query);
        if(!empty($data)) {
            return $data[0]['id_MODEL'];
        }
        return 0;
    }

	
	/**
	 * Model selection
	 * @param type $id
	 * @return type
	 */
	public function getModel($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM `{$this->models_table}`
					WHERE `id_MODEL`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Model list selection
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getModelList($limit = null, $offset = null) {
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
		
		$query = "  SELECT `{$this->models_table}`.`id_MODEL`,
						   `{$this->models_table}`.`name`,
						    `{$this->brands_table}`.`name` AS `brand`
					FROM `{$this->models_table}`
						LEFT JOIN `{$this->brands_table}`
							ON `{$this->models_table}`.`fk_BRANDid_BRAND`=`{$this->brands_table}`.`id_BRAND`{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	/**
	 * Model count calculation
	 * @return type
	 */
	public function getModelListCount() {
		$query = "  SELECT COUNT(`{$this->models_table}`.`id_MODEL`) as `amount`
					FROM `{$this->models_table}`
						LEFT JOIN `{$this->brands_table}`
							ON `{$this->models_table}`.`fk_BRANDid_BRAND`=`{$this->brands_table}`.`id_BRAND`";
		$data = mysql::select($query);
		
		return $data[0]['amount'];
	}
	
	/**
	 * Model selection by brand
	 * @param type $brandId
	 * @return type
	 */
	public function getModelListByBrand($brandId) {
		$brandId = mysql::escapeFieldForSQL($brandId);

		$query = "  SELECT *
					FROM `{$this->models_table}`
					WHERE `fk_BRANDid_BRAND`='{$brandId}'";
		$data = mysql::select($query);
		
		return $data;
	}
	
	/**
	 * Model update
	 * @param type $data
	 */
	public function updateModel($data) {
        print_r($data);
		$data = mysql::escapeFieldsArrayForSQL($data);
		
		$query = "  UPDATE `{$this->models_table}`
					SET    `name`='{$data['name']}',
						   `fk_BRANDid_BRAND`='{$data['fk_brand']}'
					WHERE `id_MODEL`='{$data['id_MODEL']}'";
		mysql::query($query);
	}
	
	/**
	 * Model insertion
	 * @param type $data
	 */
	public function insertModel($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

        $nextID = $this->lastModelID()+1;

		$query = "  INSERT INTO `{$this->models_table}`
								(
								    `id_MODEL`,
									`name`,
									`fk_BRANDid_BRAND`
								)
								VALUES
								(
								    '$nextID',
									'{$data['name']}',
									'{$data['fk_brand']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Model removal
	 * @param type $id
	 */
	public function deleteModel($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM `{$this->models_table}`
					WHERE `id_MODEL`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Amount of cars of specified model selection
	 * @param type $id
	 * @return type
	 */
	public function getCarCountOfModel($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT(`{$this->cars_table}`.`id_CAR`) AS `amount`
					FROM `{$this->models_table}`
						INNER JOIN `{$this->cars_table}`
							ON `{$this->models_table}`.`id_MODEL`=`{$this->cars_table}`.`fk_MODELid_MODEL`
					WHERE `{$this->models_table}`.`id_MODEL`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['amount'];
	}
	
	
}