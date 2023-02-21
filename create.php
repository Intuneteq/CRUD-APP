<?php
include_once './partials/headers.php';
require './users/users.php';

$user = [
    'name' => '',
    'username' => '',
    'email' => '',
    'phone' => '',
    'website' => '',

];

$errors = [
    'name' => '',
    'username' => '',
    'email' => '',
    'phone' => '',
    'website' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //validations

    //merge defined user object with incoming post data from form
    $user = array_merge($user, $_POST);
    
    //validate req body
    $isValid = validateUser($user, $errors);
    // echo '<pre>';
    // var_dump($isValid);
    // echo '</pre>';

    if ($isValid) {
        $user = createUser($_POST);

        if (isset($_FILES['picture'])) {
            uploadImage($_FILES['picture'], $user);
        }

        header('Location: index.php');
    }
}
?>

<div class="container mb-5 mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Create new User</h3>
        </div>
        <?php include_once './_form.php' ?>
    </div>
</div>


<?php
include_once './partials/footer.php';
?>