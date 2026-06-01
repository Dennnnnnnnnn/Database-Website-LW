<?php
require_once 'config.php';

$membersObj = new members();
$formErrors = null;
$data = [];

if (!empty($_POST['submit'])) {
    $required = ['Name', 'id_Level'];
    $validations = [
        'Name' => 'alfanum',
        'id_Level' => 'positivenumber'
    ];
    $validator = new validator($validations, $required);

    if ($validator->validate($_POST)) {
        $name = $_POST['Name'];
        $level = $_POST['id_Level'];

        $id = $membersObj->createMemberAuto($name, $level);

        if (!empty($_POST['Workout_name'])) {
            foreach ($_POST['Workout_name'] as $i => $workoutName) {
                $staffId = $_POST['id_Staff'][$i] ?? null;

                if ($workoutName && $staffId) {
                    $membersObj->addWorkoutPlanAuto($workoutName, $staffId, $id);
                }
            }
        }

        echo "<div class='alert alert-success'>Member created successfully</div>";
    } else {
        $formErrors = $validator->getErrorHTML();
        $data = $_POST;
    }
}
?>

<?php if ($formErrors) echo $formErrors; ?>

<style>
    .form-table td {
        padding: 12px 10px;
    }

    .form-table input[type="text"],
    .form-table select {
        width: 100%;
        padding: 8px;
    }

    .workout-row {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 15px;
    }

    .workout-row input[type="text"],
    .workout-row select {
        flex: 1;
        padding: 8px;
    }

    .remove-workout {
        color: red;
        text-decoration: none;
        font-weight: bold;
    }

    #add-workout {
        margin-top: 10px;
        display: inline-block;
    }

    input[type="submit"].btn {
        margin-top: 25px;
    }
</style>

<form method="post">
    <h3>Create Member</h3>
    <table class="form-table">
        <tr>
            <td><label>Member Name</label></td>
            <td><input type="text" name="Name" value="<?php echo $data['Name'] ?? ''; ?>" required></td>
        </tr>
        <tr>
            <td><label>Membership Level</label></td>
            <td>
                <select name="id_Level" required>
                    <?php
                    $levels = mysql::select("SELECT id_Level, Membership FROM membership_level");
                    foreach ($levels as $lvl) {
                        $sel = (isset($data['id_Level']) && $data['id_Level'] == $lvl['id_Level']) ? 'selected' : '';
                        echo "<option value='{$lvl['id_Level']}' $sel>{$lvl['Membership']}</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>

    <h4 style="margin-top: 40px;">Workout Plans</h4>
    <div id="workout-container">
        <div class="workout-row">
            <input type="text" name="Workout_name[]" placeholder="Workout Name" required>
            <select name="id_Staff[]" required>
                <option value="">Select Staff</option>
                <?php
                $staffList = mysql::select("SELECT id_Staff, Name FROM staff");
                foreach ($staffList as $staff) {
                    echo "<option value='{$staff['id_Staff']}'>{$staff['Name']}</option>";
                }
                ?>
            </select>
            <a href="#" class="remove-workout">Remove</a>
        </div>
    </div>

    <div style="margin-top: 15px;">
        <a href="#" id="add-workout" class="btn btn-secondary">Add Workout</a>
    </div>

    <br><br>
    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
</form>

<script>
    document.getElementById('add-workout').addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('workout-container');
        const row = document.createElement('div');
        row.className = 'workout-row';
        row.innerHTML = `
            <input type="text" name="Workout_name[]" placeholder="Workout Name" required style="padding: 8px;">
            <select name="id_Staff[]" required style="padding: 8px;">
                <option value="">Select Staff</option>
                <?php
                foreach ($staffList as $staff) {
                    echo "<option value='{$staff['id_Staff']}'>{$staff['Name']}</option>";
                }
                ?>
            </select>
            <a href="#" class="remove-workout">Remove</a>
        `;
        container.appendChild(row);
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-workout')) {
            e.preventDefault();
            e.target.parentElement.remove();
        }
    });
</script>
