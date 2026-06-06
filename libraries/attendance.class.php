<?php
/**
 * Car brand editing class
 *
 * @author ISK
 */

class attendance {
	
	private $attendance_table = '';
	private $models_table = '';
	
	public function __construct() {
		$this->attendance_table = config::DB_PREFIX . 'attendance';
		$this->models_table = config::DB_PREFIX . 'models';
	}
	public function getAttendance($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM {$this->attendance_table}
					WHERE `id_Attendance`='{$id}'";
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
	public function getAttendanceList($limit = null, $offset = null) {
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
					FROM {$this->attendance_table}{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 *  Brand count calculation
	 * @return type
	 */
	public function getAttendanceListCount() {
		$query = "  SELECT COUNT(`id_Attendance`) as `amount`
					FROM {$this->attendance_table}";
		$data = mysql::select($query);
		
		// 
		return $data[0]['amount'];
	}
	
	/**
	 * Brand insertion
	 * @param type $data
	 */
	public function insertAttendance($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  INSERT INTO {$this->attendance_table}
								(
									`fk_Memberid_Member`,
								    `Date`,
									`Attended`
								)
								VALUES
								(	
									'{$data['fk_Memberid_Member']}',
									'{$data['date']}',
									'{$data['attended']}'
								)";

		mysql::query($query);
	}
	
	/**
	 * Attendance update
	 * @param type $data
	 */
	public function updateAttendance($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE {$this->attendance_table}
					SET `date` = '{$data['date']}',
						`attended` = '{$data['attended']}'
					WHERE `id_Attendance` = '{$data['id_Attendance']}'";

		mysql::query($query);
	}
	
	/**
	 * Brand removal
	 * @param type $id
	 */
	public function deleteAttendance($id) {
        print_r($id);
		$id = mysql::escapeFieldForSQL($id);

		$query = "  DELETE FROM {$this->attendance_table}
					WHERE `id_BRAND`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Amount of models for specific brand selection
	 * @param type $id
	 * @return type
	 */
	public function getModelCountOfAttendance($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT({$this->models_table}.`id_MODEL`) AS `amount`
					FROM {$this->attendance_table}
						INNER JOIN {$this->models_table}
							ON {$this->attendance_table}.`id_BRAND`={$this->models_table}.`fk_BRANDid_BRAND`
					WHERE {$this->attendance_table}.`id_BRAND`='{$id}'";
		$data = mysql::select($query);

		return $data[0]['amount'];
	}



	
}
