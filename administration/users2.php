 <?php

session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    header("location: login_page.php");
    exit;
}

$user_email = $_SESSION["email"];
$user_id = $_SESSION["id"];

class User
{
    //create User object when reading data from database
    public $id;
    public $name;
    public $surname;
    public $personal_code;
    public $role;
    public $email;
    public $password;
    public $created_at;
	
	public $id_2;
	public $user_id;
    public $bruto;
    public $taxes_employee;
    public $taxes_employer;
    public $neto;
	public $dependents;
    public $created_at_2;
}

class Data
{
    //create Data object when reading data from database
    public $count_user_id;
	public $sum_bruto;
    public $sum_taxes_employee;
    public $sum_taxes_employer;
    public $sum_neto;
	public $sum_sum;
	public $created_at;

}

class ReadData
{
    //function to read data from User table
    public static function readUserTable($pdo)
    {
        $statement = $pdo->prepare("SELECT * FROM users LEFT OUTER JOIN data ON users.id=data.user_id WHERE users.role = 'view'");
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_CLASS, "User");
        return $users;

    }
}

class ReadSumData
{
    //function to read data from Data table
    public static function readDataTable($pdo)
    {
        $statement = $pdo->prepare("SELECT COUNT(user_id) as count_user_id, ROUND(SUM(bruto),2) as sum_bruto, ROUND(SUM(taxes_employee),2) as sum_taxes_employee, ROUND(SUM(taxes_employer),2) as sum_taxes_employer, ROUND(SUM(neto),2) as sum_neto, ROUND(SUM(bruto)+SUM(taxes_employer),2) as sum_sum FROM data");
        $statement->execute();

        $sumSalary = $statement->fetchAll(PDO::FETCH_CLASS, "Data");
        return $sumSalary;
    }
}

class EditData
{
    public static function editSalary($pdo, $newSalary, $id, $newDependents)
    {
			
        $statement = $pdo->prepare("UPDATE data SET bruto = round('$newSalary',2), taxes_employee = round('$newSalary' * 0.11 + (greatest((('$newSalary' - ('$newSalary' * 0.11)) - '$newDependents' * 230), 0) * 0.20),2) , taxes_employer = round('$newSalary' * 0.2409,2), neto = '$newSalary'- taxes_employee, dependents = '$newDependents' WHERE id = '$id'");
        $statement->bindParam($id, $newSalary, $newDependents, PDO::PARAM_STR);
        $statement->execute();

	}
}

require "database.php";

$users = ReadData::readUserTable($pdo);
$sumSalary = ReadSumData::readDataTable($pdo);
$salary_err = "";
$dependent_err = "";
$error_id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (isset ($_POST['newSalary']) || isset ($_POST['newDependents']) ) {

	$newSalary = $_POST['newSalary'];
	$id = $_POST['user_id'];
	$newDependents = $_POST['newDependents'];
	

	if ( ($newSalary <= 0) || ($newSalary < 430) || ($newDependents < 0) || ($newDependents > 10) || (ctype_digit($newDependents) == null) ) {

		if ($newSalary <= 0) {
		$salary_err = "Ludzu ievadi derigu algu!";
		$error_id = $id;
		}

		if ($newSalary > 0 && $newSalary < 430) {
		$salary_err = "Ludzu ievadi vismaz minimalo algu!";
		$error_id = $id;
		}

		if ($newDependents < 0 || $newDependents > 10 || ctype_digit($newDependents) == null  ) {
				$dependent_err = "Ludzu ievadi derigu apgadajamo skaitu!";
				$error_id = $id;
		}
	}
	else
	{
		EditData::editSalary($pdo, $newSalary, $id, $newDependents);
		header("location: welcome_editor.php");
		$dependent_err = "";
		$salary_err = "";
		$error_id = 0;
	}
}
}

require "header.php";
?>

<body>
<div class="background-image"></div>
<main class="container">
    <div class="row">
        <div class="dark_container col-12">

            <a href="logout.php" class="btn btn_logout uppercase" id="signout">Iziet</a>
            <h1>Darbinieki</h1><br>

            <table class="table table-hover user_table">
                <thead>
                    <tr>
                        <th scope="col">Vards</th>
                        <th scope="col">Uzvards</th>
                        <th scope="col">Alga bruto</th>
						<th scope="col">Apgadajamie</th>
                        <th scope="col">Alga neto</th>
						<th scope="col">Izmaksas uznemumam</th>
						<th scope="col">Parrekina laiks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <td><?= $user->name ?></td>
                                <td><?= $user->surname ?></td>
                                <td><input type="text" name="newSalary" value="<?= $user->bruto ?>">
									<div class="help-block salary_table">
									<?php 
										if ($user->id == $error_id) {
											echo $salary_err;
										}
									?>
									</div>
								<input hidden type="text" name="user_id" value=<?= $user->id ?>>
								<td><input type="text" name="newDependents" value="<?= $user->dependents ?>">
									<div class="help-block salary_table">
									<?php 
										if ($user->id == $error_id) {
											echo $dependent_err;
										} 
										?>
									</div>
                                <td><?= $user->neto ?></td>
								<td><?= $user->bruto + $user->taxes_employer ?></td>
								<td><?= $user->created_at ?></td>
                                <td><button type="submit" class="btn btn-danger uppercase" value="calculate">Parrekinat</button></td>
                            </form>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>

					<!--<div class="help-block salary_table"><?= $salary_err ?></div></td>
					<div class="help-block salary_table"><?= $dependent_err ?></div>-->


			<br><h1>Kopsummas</h1><br>
			<table class="table table-hover user_table">
                <thead>
                    <tr>
                        <th scope="col">Darbinieku skaits</th>
                        <th scope="col">Bruto algas</th>
						<th scope="col">Neto algas</th>
                        <th scope="col">Darbinieku nodokli</th>
                        <th scope="col">Darba deveja nodokli</th>
						<th scope="col">Kopejas izmaksas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sumSalary as $salary) { ?>
                        <tr>

                                <td><?= $salary->count_user_id ?></td>
                                <td><?= $salary->sum_bruto ?></td>
								<td><?= $salary->sum_neto ?></td>
                                <td><?= $salary->sum_taxes_employee ?></td>
								<td><?= $salary->sum_taxes_employer ?></td>
								<td><?= $salary->sum_sum ?></td>
						
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>

                   
        </div>
    </div>
</main>

<?php
require "footer.php";
?>

</body>
</html>


