<?php

session_start();

// If session variable is not set it will redirect to login page
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    header("location: ../login_page.php");
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
    public $role_description;
    public $position_id;
    public $email;
}

class ReadData
{
    //function to read data from User table
    public static function readUserTable($pdo)
    {
        $statement = $pdo->prepare("select users.id, users.name, users.surname, roles.role_description, users.position_id, users.email from users left outer join roles on users.role_id = roles.id");
        $statement->execute();

        $users = $statement->fetchAll(PDO::FETCH_CLASS, "User");
        return $users;
    }
}

class DeleteData
{
    public static function deleteUser($pdo, $user_id)
    {
        $statement = $pdo->prepare("delete from users where id =:user_id; DELETE FROM data where user_id =:user_id;");
        $statement->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $statement->execute();
    }
}

require_once "database.php";

$users = ReadData::readUserTable($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    DeleteData::deleteUser($pdo, $_POST["user_id"]);
    header("location: users.php");
}

require "../header.php";
?>

<body>

<div class="page-wrapper">

<main class="container">
    <div class="row">
            <h1 class="h1-body-text">Visi lietotāji</h1><br>

            <table class="table table-striped table-hover table-center">
                <thead>
                    <tr class="info">
                        <th scope="col"><label>Vārds</label></th>
                        <th scope="col"><label>Uzvārds</label></th>
                        <th scope="col"><label>E-pasts</label></th>
                        <th scope="col"><label>Tiesības</label></th>
                        <th scope="col"><label></label></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <td><?= $user->name ?></td>
                                <td><?= $user->surname ?></td>
                                <td><?= $user->email ?></td>
                                <td><?= $user->role_description?></td>
                                <td><input hidden type="text" name="user_id" value=<?= $user->id ?>>
                                    <button class="btn-edit">
                                    <svg role="button" type="submit" name="edit" id="edit" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                    </button>
                                </td>
                                <!--<button type="submit" class="btn btn-danger uppercase" name="delete" id="delete">Dzēst</button></td>-->
                            </form>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>

            <a href="add_user.php" class="btn btn-success uppercase">Pievienot lietotāju</a>

    </div>

</main>
</div>

<?php
require_once "../footer.php";
?>

</body>
</html>


