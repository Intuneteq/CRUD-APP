<?php
include_once './partials/headers.php';
require_once './users/users.php';

//check if id is in the GET b=global
if (!isset($_POST['id'])) {
    //import from partials
    include_once './partials/not_found.php';
    exit;
}
//assign id to a variable
$userId = $_POST['id'];

//get user by id
$user = getUserById($userId);

//if no user, echo not found
if (!$user) {
    include_once './partials/not_found.php';
    exit;
}

deleteUser($userId);

//navigate back to index
header('Location: index.php');

?>

<?php include_once './partials/footer.php' ?>