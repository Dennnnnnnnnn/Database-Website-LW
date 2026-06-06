<?php
/**
 * Contract editing class
 *
 * @author ISK
 */
class members {

	private $member_table = '';
	private $staff_table = '';
	private $membership_level_table = '';
	private $workout_plan_table = '';

	

	public function __construct() {
		$this->member_table = config::DB_PREFIX . 'member';
		$this->staff_table = config::DB_PREFIX . 'staff';
		$this->membership_level_table = config::DB_PREFIX . 'membership_level';
		$this->workout_plan_table = config::DB_PREFIX . 'workout_plan';
	}
	
	/**
	 * Contract list selection	
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getMemberList($limit, $offset) {

		$limit = mysql::escapeFieldForSQL($limit);
		$offset = mysql::escapeFieldForSQL($offset);
		
		$query = "  SELECT `{$this->member_table}`.`id_Member`,
						   `{$this->member_table}`.`name` AS `member_name`,
						   `{$this->membership_level_table}`.`id_Level` AS `id_level`,
						   `{$this->membership_level_table}`.`membership`,
						   `{$this->workout_plan_table}`.`Workout_name`,
						   `{$this->workout_plan_table}`.`id_Workout_plan`,
						   `{$this->staff_table}`.`id_Staff`,
						   `{$this->staff_table}`.`name` AS `staff_name`
					FROM `{$this->member_table}`
					LEFT JOIN `{$this->workout_plan_table}`
						ON `{$this->member_table}`.`id_Member` = `{$this->workout_plan_table}`.`fk_Memberid_Member`
					LEFT JOIN `{$this->membership_level_table}`
						ON `{$this->member_table}`.`fk_level` = `{$this->membership_level_table}`.`id_Level`
					LEFT JOIN `{$this->staff_table}`
						ON `{$this->staff_table}`.`id_Staff` = `{$this->workout_plan_table}`.`fk_Staffid_Staff`
					LIMIT {$limit} OFFSET {$offset}";
		

		$data = mysql::select($query);
		
		return $data;
	}
	


		/**
	 * Contract count calculation
	 * @return type
	 */
	public function getMemberListCount() {
		$query = "SELECT COUNT(`{$this->member_table}`.`id_Member`) AS `amount`
				  FROM `{$this->member_table}`
				  LEFT JOIN `{$this->membership_level_table}`
					  ON `{$this->member_table}`.`fk_level` = `{$this->membership_level_table}`.`id_Level`
				  LEFT JOIN `{$this->workout_plan_table}`
					  ON `{$this->workout_plan_table}`.`fk_Memberid_Member` = `{$this->member_table}`.`id_Member`
				  LEFT JOIN `{$this->staff_table}`
					  ON `{$this->workout_plan_table}`.`fk_Staffid_Staff` = `{$this->staff_table}`.`id_Staff`";
	
		$data = mysql::select($query);
	
		return $data[0]['amount'];
	}

	/**
	 * Contract selection
	 * @param type $nr
	 * @return type
	 */
	public function getMember($id) {

		$id = mysql::escapeFieldForSQL($id);
		
		$query = "SELECT 
				`{$this->member_table}`.`id_Member`,
				`{$this->member_table}`.`name`,
				`{$this->member_table}`.`surname`,
				`{$this->member_table}`.`date_of_birth`,
				`{$this->member_table}`.`gender`,
				`{$this->member_table}`.`phone`,
				`{$this->member_table}`.`email`,
				`{$this->member_table}`.`adress`,
				`{$this->member_table}`.`height`,
				`{$this->member_table}`.`weight`,
				`{$this->member_table}`.`fk_level`,
				`{$this->membership_level_table}`.`membership` AS `membership_level`,
				`{$this->workout_plan_table}`.`Workout_name`,
				`{$this->workout_plan_table}`.`Plan_start_date`,
				`{$this->workout_plan_table}`.`Plan_end_date`,
				`{$this->staff_table}`.`id_Staff`,
				`{$this->staff_table}`.`Name` AS `staff_name`
			FROM `{$this->member_table}`
			LEFT JOIN `{$this->membership_level_table}`
				ON `{$this->member_table}`.`fk_level` = `{$this->membership_level_table}`.`id_Level`
			LEFT JOIN `{$this->workout_plan_table}`
				ON `{$this->member_table}`.`id_Member` = `{$this->workout_plan_table}`.`fk_Memberid_Member`
			LEFT JOIN `{$this->staff_table}`
				ON `{$this->workout_plan_table}`.`fk_Staffid_Staff` = `{$this->staff_table}`.`id_Staff`
			WHERE `{$this->member_table}`.`id_Member` = '{$id}'";
		
		$data = mysql::select($query);
		
		return $data[0]; 
	}
	
	/**
	 * Check if member exists by email or another unique attribute
	 * @param string $email
	 * @return int
	 */
	public function checkIfMemberExists($email) {

		$email = mysql::escapeFieldForSQL($email);
		$query = "
			SELECT COUNT(`{$this->member_table}`.`id_Member`) AS `amount`
			FROM `{$this->member_table}`
			WHERE `{$this->member_table}`.`email` = '{$email}'";


		$data = mysql::select($query);


		return $data[0]['amount'];
	}

	/**
	 * Check if workout plan exists for member
	 * @param type $memberId
	 * @param type $workoutPlanId
	 * @return type
	 */
	public function checkIfWorkoutPlanExists($memberId, $workoutPlanId) {
		$query = "SELECT COUNT(`{$this->workout_plan_table}`.`id_Workout_plan`) AS `amount`
				FROM `{$this->workout_plan_table}`
				WHERE `fk_Memberid_Member` = '{$memberId}' AND `id_Workout_plan` = '{$workoutPlanId}'";
		$data = mysql::select($query);

		return $data[0]['amount'];
	}

	/**
	 * Get list of workout plans for a member
	 * @param type $memberId
	 * @return type
	 */
	public function getMemberWorkoutPlans($memberId) {
		$memberId = mysql::escapeFieldForSQL($memberId);

		$query = "SELECT `{$this->workout_plan_table}`.`id_Workout_plan`,
						`{$this->workout_plan_table}`.`Workout_name`,
						`{$this->workout_plan_table}`.`id_Workout_plan`,
						`{$this->staff_table}`.`Name` AS `staff_name`
				FROM `{$this->workout_plan_table}`
				LEFT JOIN `{$this->staff_table}`
					ON `{$this->workout_plan_table}`.`fk_Staffid_Staff` = `{$this->staff_table}`.`id_Staff`
				WHERE `{$this->workout_plan_table}`.`fk_Memberid_Member` = '{$memberId}'";

		$data = mysql::select($query);

		return $data;
	}


	/**
	 * Contract update
	 * @param type $data
	 */
	public function updateMemberData($data) {

		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "UPDATE `{$this->member_table}`
				SET    `name` = '{$data['name']}',
						`surname` = '{$data['surname']}',
						`date_of_birth` = '{$data['date_of_birth']}',
						`gender` = '{$data['gender']}',
						`phone` = '{$data['phone']}',
						`email` = '{$data['email']}',
						`adress` = '{$data['adress']}',
						`height` = '{$data['height']}',
						`weight` = '{$data['weight']}',
						`fk_level` = '{$data['fk_level']}'
				WHERE `id_Member` = '{$data['id_Member']}'";

		mysql::query($query);


		if (isset($data['workoutPlan'])) {
			$query = "UPDATE `{$this->workout_plan_table}`
					SET    `Workout_name` = '{$data['workoutPlan']['Workout_name']}',
							`Plan_start_date` = '{$data['workoutPlan']['Plan_start_date']}',
							`Plan_end_date` = '{$data['workoutPlan']['Plan_end_date']}',
							`fk_Staffid_Staff` = '{$data['workoutPlan']['fk_Staffid_Staff']}'
					WHERE `fk_Memberid_Member` = '{$data['id_Member']}'";

			mysql::query($query);
		}


		if (isset($data['membershipLevel'])) {
			$query = "UPDATE `{$this->membership_level_table}`
					SET    `membership` = '{$data['membershipLevel']}'
					WHERE `id_Level` = '{$data['fk_level']}'";

			mysql::query($query);
		}
	}

	public function updateOrderedService($data) {

		$data = mysql::escapeFieldsArrayForSQL($data);

		if (isset($data['price'], $data['amount'], $data['fk_Memberid_Member'], $data['fk_Workout_plan_id_Workout_plan'], $data['fk_Staffid_Staff'])) {
			
			$query = "UPDATE `{$this->workout_plan_table}`
					SET `price` = '{$data['price']}',
						`amount` = '{$data['amount']}'
					WHERE `fk_Memberid_Member` = '{$data['fk_Memberid_Member']}'
					AND `id_Workout_plan` = '{$data['fk_Workout_plan_id_Workout_plan']}'
					AND `fk_Staffid_Staff` = '{$data['fk_Staffid_Staff']}'";
			

			mysql::query($query);
		} 
	}
	
	public function insertMember($data) {

		$data = mysql::escapeFieldsArrayForSQL($data);


		$query = "INSERT INTO `{$this->member_table}`
					(
						`name`,
						`surname`,
						`date_of_birth`,
						`gender`,
						`phone`,
						`email`,
						`adress`,
						`height`,
						`weight`,
						`fk_level`
					)
					VALUES
					(
						'{$data['name']}',
						'{$data['surname']}',
						'{$data['date_of_birth']}',
						'{$data['gender']}',
						'{$data['phone']}',
						'{$data['email']}',
						'{$data['adress']}',
						'{$data['height']}',
						'{$data['weight']}',
						'{$data['fk_level']}'
					)";
		

		mysql::query($query);
	}
	public function deletePayments($memberId) {

		$memberId = mysql::escapeFieldForSQL($memberId);
		
		$query = "DELETE FROM payments WHERE fk_Personal_training_sessionid_Personal_training_session IN (
			SELECT id_Personal_training_session FROM personal_training_session WHERE fk_Attendanceid_Attendance IN (
				SELECT id_Attendance FROM attendance WHERE fk_Memberid_Member = '{$memberId}'
			)
		)";
		mysql::query($query);
	
		$query = "DELETE FROM payments WHERE fk_Memberid_Member = '{$memberId}'";
		mysql::query($query);
	}
	
	
	public function deletePersonalTrainingSessions($memberId) {

		$memberId = mysql::escapeFieldForSQL($memberId);
	
		$query = "DELETE FROM personal_training_session WHERE fk_Attendanceid_Attendance IN (
			SELECT id_Attendance FROM attendance WHERE fk_Memberid_Member = '{$memberId}'
		)";
		mysql::query($query);
	}
	
	public function deleteAttendance($memberId) {

		$memberId = mysql::escapeFieldForSQL($memberId);
	
		$query = "DELETE FROM attendance WHERE fk_Memberid_Member = '{$memberId}'";
		mysql::query($query);
	}
	
	public function deleteWorkoutPlans($memberId) {

		$memberId = mysql::escapeFieldForSQL($memberId);
	
		$query = "DELETE FROM workout_plan WHERE fk_Memberid_Member='{$memberId}'";
		mysql::query($query);
	}
	

	
	public function deleteComplains($memberId) {

		$memberId = mysql::escapeFieldForSQL($memberId);
	
		$query = "DELETE FROM complains WHERE fk_Memberid_Member='{$memberId}'";
		mysql::query($query);
	}
	
	public function deleteDietPlans($memberId) {
		$memberId = mysql::escapeFieldForSQL($memberId);
	

		$query = "DELETE FROM diet_plans WHERE fk_Memberid_Member='{$memberId}'";
		mysql::query($query);
	}
	
	public function deleteNotifications($memberId) {

		$memberId = mysql::escapeFieldForSQL($memberId);
	

		$query = "DELETE FROM notifications WHERE fk_Memberid_Member='{$memberId}'";
		mysql::query($query);
	}
	
	public function deleteMember($memberId) {

		$memberId = mysql::escapeFieldForSQL($memberId);
	

		$this->deletePayments($memberId);
		$this->deletePersonalTrainingSessions($memberId);
		$this->deleteAttendance($memberId);
		$this->deleteWorkoutPlans($memberId);
		
		$this->deleteComplains($memberId);
		$this->deleteDietPlans($memberId);
		$this->deleteNotifications($memberId);
	
		$query = "DELETE FROM {$this->member_table} WHERE id_Member='{$memberId}'";
		mysql::query($query);
	}
	
	/**
	 * Update ordered workout plans for the member
	 * @param type $data
	 */
	public function updateOrderedWorkoutPlans($data) {
		$data = mysql::escapeFieldsArrayForSQL($data);


		$this->deleteOrderedWorkoutPlans($data['member_id']);
		
		if (isset($data['workout_plans']) && sizeof($data['workout_plans']) > 0) {
			foreach ($data['workout_plans'] as $key => $val) {
				$tmp = explode("#", $val);
				$workoutPlanId = $tmp[0]; 
				$workoutPlanName = $tmp[1];

				$query = "INSERT INTO `{$this->workout_plan_table}`
							(
								`fk_Memberid_Member`,
								`id`,
								`workout_plan_name`
							)
							VALUES
							(
								'{$data['member_id']}',
								'{$workoutPlanId}',
								'{$workoutPlanName}'
							)";
				mysql::query($query);
			}
		}
	}

	/**
	 * Ordered workout plan inclusion
	 * @param type $data
	 */
	public function insertOrderedWorkoutPlan($data) {

		$data = mysql::escapeFieldsArrayForSQL($data);

		$query = "  INSERT INTO `{$this->workout_plan_table}`
					(
						`id`, 
						`fk_Memberid_Member`, 
						`workout_plan_name`, 
						`Plan_start_date`, 
						`Plan_end_date`, 
						`fk_Staffid_Staff`
					)
					VALUES
					(
						'{$nextID}', 
						'{$data['fk_Memberid_Member']}', 
						'{$data['workout_plan_name']}', 
						'{$data['Plan_start_date']}',
						'{$data['Plan_end_date']}',
						'{$data['fk_Staffid_Staff']}'
					)";


		mysql::query($query);
	}

	/**
	 * Get membership levels list
	 * @return type
	 */
	public function getMembershipLevels() {

		$query = "  SELECT *
					FROM `{$this->membership_level_table}`"; 

		$data = mysql::select($query);

		return $data; 
	}


	public function getMemberData($memberId) {
		$memberId = mysql::escapeFieldForSQL($memberId);
	
		$query = "
			SELECT 
				m.id_Member, 
				m.name, 
				m.fk_level,              
				l.Membership, 
				w.workout_name, 
				w.id_Workout_plan,       
				s.name AS staff_name, 
				s.id_Staff               
			FROM {$this->member_table} m
			LEFT JOIN membership_level l ON m.fk_level = l.id_Level
			LEFT JOIN workout_plan w ON m.id_Member = w.fk_Memberid_Member
			LEFT JOIN staff s ON w.fk_Staffid_Staff = s.id_Staff
			WHERE m.id_Member = '{$memberId}'
		";
	
		return mysql::select($query);
	}
	
	
	

	public function updateMembershipLevel($memberId, $newLevelId) {
		$memberId = mysql::escapeFieldForSQL($memberId);
		$newLevelId = mysql::escapeFieldForSQL($newLevelId);

		$query = "
			UPDATE {$this->member_table}
			SET fk_level = '{$newLevelId}'
			WHERE id_Member = '{$memberId}'
		";

		return mysql::query($query);
	}

	public function updateWorkoutPlan($memberId, $newWorkoutPlanId) {
		$memberId = mysql::escapeFieldForSQL($memberId);
		$newWorkoutPlanId = mysql::escapeFieldForSQL($newWorkoutPlanId);

		$query = "
			UPDATE {$this->member_table}
			SET fk_workout_id = '{$newWorkoutPlanId}'  -- Corrected to fk_workout_id
			WHERE id_Member = '{$memberId}'
		";

		return mysql::query($query);
	}

	public function updateMember($id, $membershipLevel, $name, $workoutId, $staffId, $workout_name) {
		$id = mysql::escapeFieldForSQL($id);
		$membershipLevel = mysql::escapeFieldForSQL($membershipLevel);
		$name = mysql::escapeFieldForSQL($name);
		$workoutId = mysql::escapeFieldForSQL($workoutId);
		$staffId = mysql::escapeFieldForSQL($staffId);
		$query1 = "
			UPDATE member
			SET name = '{$name}', fk_level = '{$membershipLevel}'
			WHERE id_Member = '{$id}'
		";
		$success1 = mysql::query($query1);
		if (!$success1) {
			error_log("Error updating member: " . mysql_error());
			return false;
		}
	
		$query2 = "
			UPDATE workout_plan
			SET fk_Staffid_Staff = '{$staffId}', Workout_name = '{$workout_name}'
			WHERE id_Workout_plan = '{$workoutId}' 
			AND fk_Memberid_Member = '{$id}'
		";
		$success2 = mysql::query($query2);
		if (!$success2) {
			error_log("Error updating workout plan: " . mysql_error());
			return false;
		}
	
		return true;
	}

	public function getStaffList() {
		$query = "
			SELECT id_Staff, name
			FROM {$this->staff_table}
			ORDER BY name
		";
	
		return mysql::select($query);
	}
	
	public function getMembershipLevelss() {
		$query = "
			SELECT id_Level, Membership
			FROM {$this->membership_level_table}
			ORDER BY Membership
		";
	
		return mysql::select($query);
	}

	public function getWorkoutPlans() {
        $query = "SELECT id_Workout_plan, Workout_name FROM workout_plan";
        return mysql::select($query);
    }
	
    public function checkIfMemberExistsWithID($id_Member) {

        $id_Member = (int)$id_Member;

        $query = "SELECT COUNT(*) as count FROM member WHERE id_Member = $id_Member";

        $result = mysql::select($query);

        return $result[0]['count'] > 0;
    }


    public function createMember($id_Member, $name, $levelId) {

        $id_Member = (int)$id_Member;
        $name = mysql::escapeFieldForSQL($name);  
        $levelId = (int)$levelId;

        $query = "INSERT INTO member (id_Member, Name, fk_Level) VALUES ($id_Member, '$name', $levelId)";

        mysql::query($query);
    }

    public function addWorkoutPlan($id_Workout_plan, $Workout_name, $id_Staff, $fk_Memberid_Member) {
        
        $id_Workout_plan = (int)$id_Workout_plan;
        $Workout_name = mysql::escapeFieldForSQL($Workout_name);  
        $id_Staff = (int)$id_Staff;
        $fk_Memberid_Member = (int)$fk_Memberid_Member;

        $query = "INSERT INTO workout_plan (id_Workout_plan, Workout_name, fk_Staffid_Staff, fk_Memberid_Member) 
                  VALUES ($id_Workout_plan, '$Workout_name', $id_Staff, $fk_Memberid_Member)";

        mysql::query($query);
    }

	public function createMemberAuto($name, $level) {
		$name = mysql::escapeFieldForSQL($name);
		$level = (int)$level;
	
		mysql::query("INSERT INTO member (Name, fk_Level) VALUES ('$name', $level)");
		
		$rows = mysql::select("SELECT id_Member FROM member WHERE Name = '$name' AND fk_Level = $level ORDER BY id_Member DESC LIMIT 1");
		return $rows[0]['id_Member'] ?? null;
	}
	
	
	
	public function addWorkoutPlanAuto($workoutName, $staffId, $memberId) {
		$workoutName = mysql::escapeFieldForSQL($workoutName);
		$staffId = (int)$staffId;
		$memberId = (int)$memberId;
	
		mysql::query("INSERT INTO workout_plan (Workout_name, fk_Staffid_Staff, fk_Memberid_Member)
					  VALUES ('$workoutName', $staffId, $memberId)");
	}
	
	


}

?>
