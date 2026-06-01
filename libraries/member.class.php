<?php
/**
 * Car brand editing class
 *
 * @author ISK
 */

class member {
	
	private $member_table = '';
	private $workoutPlan_table = '';
	
	public function __construct() {
		$this->member_table = config::DB_PREFIX . 'member';
		$this->workoutPlan_table = config::DB_PREFIX . 'workout_plan';
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
	public function getBrand($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT *
					FROM {$this->member_table}
					WHERE `id_Member`='{$id}'";
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
	public function getBrandList($limit = null, $offset = null) {
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
					FROM {$this->member_table}{$limitOffsetString}";
		$data = mysql::select($query);
		
		//
		return $data;
	}

	/**
	 *  Brand count calculation
	 * @return type
	 */
	public function getBrandListCount() {
		$query = "  SELECT COUNT(`id_Member`) as `amount`
					FROM {$this->member_table}";
		$data = mysql::select($query);
		
		// 
		return $data[0]['amount'];
	}
	
	public function insertMember($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
	
		// Check if 'fk_level' is provided, and set a default value if not
		if (!isset($data['fk_level']) || empty($data['fk_level'])) {
			// You can choose a default value here. For instance, '1' is the default membership level.
			$data['fk_level'] = 1;
		}
	
		// Validate if the provided fk_level exists in the membership_level table
		$levelQuery = "SELECT `id_Level` FROM `membership_level` WHERE `id_Level` = '{$data['fk_level']}'";
		$levelCheck = mysql::select($levelQuery);
	
		// If the level doesn't exist, handle the error
		if (empty($levelCheck)) {
			// Handle the error: invalid fk_level
			echo "Error: Invalid membership level.";
			exit();
		}
	
		// Insert into member table
		$query = "INSERT INTO {$this->member_table}
					(
						`Name`,
						`Surname`,
						`Date_of_birth`,
						`Gender`,
						`Phone_number`,
						`Email`,
						`Adress`,
						`Height`,
						`Weight`,
						`fk_level` 
					)
					VALUES
					(
						'{$data['name']}',
						'{$data['surname']}',
						'{$data['date_of_birth']}',
						'{$data['gender']}',
						'{$data['phone_number']}',
						'{$data['email']}',
						'{$data['adress']}',
						'{$data['height']}',
						'{$data['weight']}',
						'{$data['fk_level']}' 
					)";
		mysql::query($query);

	}
	
	
	
	
	
	/**
	 * Brand update
	 * @param type $data
	 */
	public function updateMemberP($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  UPDATE {$this->member_table}
					SET 
                `name` = '{$data['name']}',
                `surname` = '{$data['surname']}',
                `date_of_birth` = '{$data['date_of_birth']}',
                `gender` = '{$data['gender']}',
                `phone_number` = '{$data['phone_number']}',
                `email` = '{$data['email']}',
                `adress` = '{$data['adress']}',
                `height` = '{$data['height']}',
                `weight` = '{$data['weight']}'
              WHERE `id_Member` = '{$data['id_Member']}'";
		mysql::query($query);
	}
	public function updateMember($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);
	
		$fieldsToUpdate = [];
	
		// Поля, які можна оновлювати
		$updatableFields = ['name', 'surname', 'date_of_birth', 'gender', 'phone_number', 'email', 'adress', 'height', 'weight'];
	
		foreach ($updatableFields as $field) {
			if (isset($data[$field]) && $data[$field] !== '') {
				$fieldsToUpdate[] = "`$field` = '{$data[$field]}'";
			}
		}
	
		if (empty($fieldsToUpdate)) {
			// Немає жодного поля для оновлення
			return;
		}
	
		// Формуємо основний запит
		$query = "
			UPDATE {$this->member_table}
			SET " . implode(', ', $fieldsToUpdate) . "
			WHERE `id_Member` = '{$data['id_Member']}'
		";
	
		mysql::query($query);
	}
	

	// public function deleteMemberCompletely($id) {
	// 	$id = mysql::escapeFieldForSQL($id);
	
	// 	// 1. Отримати всі пов'язані attendance.id
	// 	$query = "SELECT id_Attendance FROM attendance WHERE fk_Memberid_Member = '{$id}'";
	// 	$attendanceRows = mysql::select($query);
	// 	$attendanceIds = array_column($attendanceRows, 'id_Attendance');
	// 	$attendanceIdsString = implode(",", $attendanceIds);
	
	// 	// 2. Видалити платежі, які пов’язані з персональними тренуваннями через attendance
	// 	if (!empty($attendanceIdsString)) {
	// 		$query = "DELETE payments FROM payments 
	// 				  INNER JOIN personal_training_session ON payments.fk_Personal_training_sessionid_Personal_training_session = personal_training_session.id_Personal_training_session
	// 				  WHERE personal_training_session.fk_Attendanceid_Attendance IN ($attendanceIdsString)";
	// 		mysql::query($query);
	
	// 		// 3. Видалити персональні тренування
	// 		$query = "DELETE FROM personal_training_session 
	// 				  WHERE fk_Attendanceid_Attendance IN ($attendanceIdsString)";
	// 		mysql::query($query);
	// 	}
	
	// 	// 4. Видалити workout plans
	// 	$query = "DELETE FROM workout_plan WHERE fk_Memberid_Member = '{$id}'";
	// 	mysql::query($query);
	
	// 	// 5. Видалити diet plans
	// 	$query = "DELETE FROM diet_plans WHERE fk_Memberid_Member = '{$id}'";
	// 	mysql::query($query);
	
	// 	// 6. Видалити notifications
	// 	$query = "DELETE FROM notifications WHERE fk_Memberid_Member = '{$id}'";
	// 	mysql::query($query);
	
	// 	// 7. Видалити complains
	// 	$query = "DELETE FROM complains WHERE fk_Memberid_Member = '{$id}'";
	// 	mysql::query($query);
	
	// 	// 8. Видалити attendance
	// 	$query = "DELETE FROM attendance WHERE fk_Memberid_Member = '{$id}'";
	// 	mysql::query($query);
	
	// 	// 9. Видалити staff, якщо учасник є працівником (враховуючи зв’язок)
	// 	$query = "DELETE FROM staff WHERE id_Staff = '{$id}'";
	// 	mysql::query($query);
	
	// 	// 10. Нарешті, видалити member
	// 	$query = "DELETE FROM member WHERE id_Member = '{$id}'";
	// 	mysql::query($query);
	// }
	
	// public function deleteMember($memberId) {
	// 	// Escape the memberId to prevent SQL injection
	// 	$memberId = mysql::escapeFieldForSQL($memberId);
	
	// 	// 1. Delete payments (related via personal_training_session and directly by member)
	// 	$query = "DELETE FROM payments 
	// 			  WHERE fk_Memberid_Member = '{$memberId}' 
	// 				 OR fk_Personal_training_sessionid_Personal_training_session IN (
	// 					SELECT id_Personal_training_session 
	// 					FROM personal_training_session 
	// 					WHERE fk_Attendanceid_Attendance IN (
	// 						SELECT id_Attendance FROM attendance WHERE fk_Memberid_Member = '{$memberId}'
	// 					)
	// 			  )";
	// 	mysql::query($query);

		
	// 	// 2. Delete personal training sessions (linked via attendance)
	// 	$query = "DELETE FROM personal_training_session 
	// 			  WHERE fk_Attendanceid_Attendance IN (
	// 				  SELECT id_Attendance FROM attendance WHERE fk_Memberid_Member = '{$memberId}'
	// 			  )";
	// 	mysql::query($query);

	
	// 	// 3. Delete attendances
	// 	$query = "DELETE FROM attendance WHERE fk_Memberid_Member = '{$memberId}'";
	// 	mysql::query($query);

	
	// 	// 4. Delete workout plans
	// 	$query = "DELETE FROM workout_plan WHERE fk_Memberid_Member = '{$memberId}'";
	// 	mysql::query($query);

	
	// 	// 5. Delete complains
	// 	$query = "DELETE FROM complains WHERE fk_Memberid_Member = '{$memberId}'";
	// 	mysql::query($query);

	
	// 	// 6. Delete diet plans
	// 	$query = "DELETE FROM diet_plans WHERE fk_Memberid_Member = '{$memberId}'";
	// 	mysql::query($query);

	// 	// 7. Delete notifications
	// 	$query = "DELETE FROM notifications WHERE fk_Memberid_Member = '{$memberId}'";
	// 	mysql::query($query);

	
	// 	// 8. Finally, delete the member
	// 	$query = "DELETE FROM {$this->member_table} WHERE id_Member = '{$memberId}'";
	// 	mysql::query($query);

	// } було 19-30 12.04.2024
	
	public function deletePayments($memberId) {
		// Escape the memberId to prevent SQL injection
		$memberId = mysql::escapeFieldForSQL($memberId);
		
		// First, delete payments related to personal training sessions of the member
		$query = "DELETE FROM payments WHERE fk_Personal_training_sessionid_Personal_training_session IN (
			SELECT id_Personal_training_session FROM personal_training_session WHERE fk_Attendanceid_Attendance IN (
				SELECT id_Attendance FROM attendance WHERE fk_Memberid_Member = '{$memberId}'
			)
		)";
		mysql::query($query);
	
		// Optionally, if there is a direct foreign key relationship from payments to members:
		$query = "DELETE FROM payments WHERE fk_Memberid_Member = '{$memberId}'";
		mysql::query($query);
	}
	
	
	public function deletePersonalTrainingSessions($memberId) {
		// Escape the memberId to prevent SQL injection
		$memberId = mysql::escapeFieldForSQL($memberId);
	
		// Delete personal training sessions
		$query = "DELETE FROM personal_training_session WHERE fk_Attendanceid_Attendance IN (
			SELECT id_Attendance FROM attendance WHERE fk_Memberid_Member = '{$memberId}'
		)";
		mysql::query($query);
	}
	
	public function deleteAttendance($memberId) {
		// Escape the memberId to prevent SQL injection
		$memberId = mysql::escapeFieldForSQL($memberId);
	
		// Delete attendance records
		$query = "DELETE FROM attendance WHERE fk_Memberid_Member = '{$memberId}'";
		mysql::query($query);
	}
	
	public function deleteWorkoutPlans($memberId) {
		// Escape the memberId to prevent SQL injection
		$memberId = mysql::escapeFieldForSQL($memberId);
	
		// Delete workout plans related to the member
		$query = "DELETE FROM workout_plan WHERE fk_Memberid_Member='{$memberId}'";
		mysql::query($query);
	}
	

	
	public function deleteComplains($memberId) {
		// Escape the memberId to prevent SQL injection
		$memberId = mysql::escapeFieldForSQL($memberId);
	
		// Delete complains related to the member
		$query = "DELETE FROM complains WHERE fk_Memberid_Member='{$memberId}'";
		mysql::query($query);
	}
	
	public function deleteDietPlans($memberId) {
		// Escape the memberId to prevent SQL injection
		$memberId = mysql::escapeFieldForSQL($memberId);
	
		// Delete diet plans related to the member
		$query = "DELETE FROM diet_plans WHERE fk_Memberid_Member='{$memberId}'";
		mysql::query($query);
	}
	
	public function deleteNotifications($memberId) {
		// Escape the memberId to prevent SQL injection
		$memberId = mysql::escapeFieldForSQL($memberId);
	
		// Delete notifications related to the member
		$query = "DELETE FROM notifications WHERE fk_Memberid_Member='{$memberId}'";
		mysql::query($query);
	}
	
	public function deleteMember($memberId) {
		// Escape the memberId to prevent SQL injection
		$memberId = mysql::escapeFieldForSQL($memberId);
	
		// Delete payments, personal training sessions, attendance, and other related data
		$this->deletePayments($memberId);
		$this->deletePersonalTrainingSessions($memberId);
		$this->deleteAttendance($memberId);
		$this->deleteWorkoutPlans($memberId);
		
		$this->deleteComplains($memberId);
		$this->deleteDietPlans($memberId);
		$this->deleteNotifications($memberId);
	
		// Finally, delete the member
		$query = "DELETE FROM {$this->member_table} WHERE id_Member='{$memberId}'";
		mysql::query($query);
	}
	
	



	
	
	

	
	
	
	/**
	 * Amount of models for specific brand selection
	 * @param type $id
	 * @return type
	 */
	public function getModelCountOfBrand($id) {
		$id = mysql::escapeFieldForSQL($id);

		$query = "  SELECT COUNT({$this->workoutPlan_table}.`id_Workout_plan`) AS `amount`
					FROM {$this->member_table}
						INNER JOIN {$this->workoutPlan_table}
							ON {$this->member_table}.`id_Member`={$this->workoutPlan_table}.`fk_Memberid_Member`
					WHERE {$this->workoutPlan_table}.`fk_Memberid_Member`='{$id}'";
		$data = mysql::select($query);

		return $data[0]['amount'];
	}



	
}