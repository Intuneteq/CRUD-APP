<?php
include_once './partials/headers.php';
require_once './users/users.php';

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

// echo '<pre>';
// var_dump($user);
// echo '</pre>';

?>

<div class="container">
    <div class="card mb-5 mt-5">
        <div class="card-header">
            <h3>View User: <?php echo $user['name'] ?></h3>
        </div>
        <div class="card-body">
            <a class="btn btn-secondary" href="update.php?id=<?php echo $userId ?>">update <?php echo $user['username'] ?></a>
            <form style="display: inline-block;" action="delete.php" method="post">
                <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
                <button class="btn btn-sm btn-outline-danger">Delete <?php echo $user['username'] ?></button>
            </form>
        </div>
        <table class="table">
            <tbody>
                <tr>
                    <th>Name:</th>
                    <td><?php echo $user['name'] ?></td>
                </tr>
                <tr>
                    <th>Username:</th>
                    <td><?php echo $user['username'] ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?php echo $user['email'] ?></td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td><?php echo $user['phone'] ?></td>
                </tr>
                <tr>
                    <th>Website:</th>
                    <td>
                        <a href="http://<?php echo $user['website'] ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo $user['website'] ?>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



<?php include_once './partials/footer.php' ?>