<?php
include_once './partials/headers.php';
require './users/users.php';

// $userId = $_POST['id'];

//check if id is in the GET b=global
if (!isset($_GET['id'])) {
    //import from partials
    include_once './partials/not_found.php';
    exit;
}
//assign id to a variable
$userId = $_GET['id'];

//get user by id
$user = getUserById($userId);

//if no user, echo not found
if (!$user) {
    include_once './partials/not_found.php';
    exit;
}

$errors = [
    'name' => '',
    'username' => '',
    'email' => '',
    'phone' => '',
    'website' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = array_merge($user, $_GET);
    $isValid = validateUser($user, $errors);

    if ($isValid) {
        $updatedUser = updateUser($_POST, $userId);
        if (isset($_FILES['picture'])) {
            uploadImage($_FILES['picture'], $user);
        }
        header('Location: index.php');
    }
}

?>
<div class="container mt-5 mb-5">
    <div class="card">
        <div class="card-header">
            <h3>Update user <b><?php echo $user['name'] ?></b></h3>
        </div>
        <?php include_once './_form.php' ?>
    </div>
</div>

<?php
include_once './partials/footer.php';
?>