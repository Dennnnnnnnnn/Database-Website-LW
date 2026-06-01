<?php
$membersObj = new members(); // об'єкт для роботи з учасниками

$formErrors = null;
$data = array();
// $required = array('id_Member', 'Membership', 'name', 'Workout_name', 'staff_name');
$required = array('id_Member', 'Membership', 'name', 'id_Workout_plan', 'id_Staff');

$staffList = $membersObj->getStaffList();
$membershipLevels = $membersObj->getMembershipLevels();
$workoutPlans = $membersObj->getWorkoutPlans();

// Коли форма відправлена
if (!empty($_POST['submit'])) {
    $validations = array(
        'id_Member' => 'positivenumber',
        'Membership' => 'positivenumber',
        'name' => 'alfanum',
        'id_Workout_plan' => 'positivenumber',
        'id_Staff' => 'positivenumber'
    );

    $validator = new validator($validations, $required);

    if ($validator->validate($_POST)) {
        $memberId = $_POST['id_Member'];

        $updateResult = $membersObj->updateMember(
            $memberId,
            $_POST['Membership'],
            $_POST['name'],
            $_POST['id_Workout_plan'],
            $_POST['id_Staff'],
            'Workout_name'
        );
        

        if ($updateResult) {
            common::redirect("index.php?module={$module}&action=list");
            die();
        } else {
            $formErrors = "There was an error updating the member's data.";
        }
    } else {
        $formErrors = $validator->getErrorHTML();
        $data = $_POST;
    }
} else {
    $memberData = $membersObj->getMemberData($id);
    if ($memberData) {
        $data = $memberData[0];
        //?????
        $data['id_Workout_plan'] = $memberData[0]['id_Workout_plan'];
        $data['id_Staff'] = $memberData[0]['id_Staff'];
        //???????
    }
}
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="index.php?module=<?php echo $module; ?>&action=list">Members</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo !empty($id) ? "Edit Member" : "New Member"; ?></li>
    </ol>
</nav>

<?php if ($formErrors != null) { ?>
    <div class="alert alert-danger"><?php echo $formErrors; ?></div>
<?php } ?>

<!-- Form -->
<form action="" method="post" class="d-grid gap-3">
    <h4 class="mt-3">Member Information</h4>

    <div class="form-group">
        <label for="id_Member">Member ID<span> *</span></label>
        <input type="text" id="id_Member" name="id_Member" class="form-control" value="<?php echo isset($data['id_Member']) ? $data['id_Member'] : ''; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="Membership">Membership Level<span> *</span></label>
        <select id="Membership" name="Membership" class="form-control">
            <option value="">Select Membership Level</option>
            <?php foreach ($membershipLevels as $level) { ?>
                <option value="<?php echo $level['id_Level']; ?>" <?php echo (isset($data['fk_level']) && $data['fk_level'] == $level['id_Level']) ? 'selected' : ''; ?>>
                    <?php echo $level['Membership']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="name">Name<span> *</span></label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
    </div>


    <div class="form-group">
        <label for="id_Workout_plan">Workout Plan<span> *</span></label>
        <select id="id_Workout_plan" name="id_Workout_plan" class="form-control">
            <option value="">Select Workout Plan</option>
            <?php foreach ($workoutPlans as $plan) { ?>
                <option value="<?php echo $plan['id_Workout_plan']; ?>" <?php echo (isset($data['id_Workout_plan']) && $data['id_Workout_plan'] == $plan['id_Workout_plan']) ? 'selected' : ''; ?>>
                    <?php echo $plan['Workout_name']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_Staff">Assigned Trainer<span> *</span></label>
        <select id="id_Staff" name="id_Staff" class="form-control">
            <option value="">Select Trainer</option>
            <?php foreach ($staffList as $staff) { ?>
                <option value="<?php echo $staff['id_Staff']; ?>" <?php echo (isset($data['id_Staff']) && $data['id_Staff'] == $staff['id_Staff']) ? 'selected' : ''; ?>>
                    <?php echo $staff['name']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <input type="submit" class="btn btn-primary w-25" name="submit" value="Save">

    
</form>
