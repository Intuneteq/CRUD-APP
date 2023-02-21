<?php

function getUsers()
{
    //read json file.
    $fileContents = file_get_contents(filename: __DIR__ . '/users.json');

    //using jsondecode will convert json to objects. true converts to associative array
    return json_decode($fileContents, true);
}


function getUserById($id)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }
    return null;
};

function createUser($data)
{
    $users = getUsers();

    //assign id to post
    $data['id'] = rand(100000, 200000);

    $users[] = $data;

    //update json
    putJson($users);

    return $data;
}

function updateUser($data, $id)
{
    //updated user will be stored here
    $updatedUser = [];

    //get users in json
    $users = getUsers();

    //for each user, $i being the index position, merge updated user
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            $users[$i] = $updatedUser = array_merge($user, $data);
        }
    }
    //update json
    putJson($users);
    return $updatedUser;
}

function deleteUser($id)
{
    $users = getUsers();

    //for each user, $i being the index position, splice user from array
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            array_splice($users, $i, 1);
        }
    }
    //put current users array in json file
    putJson($users);
}

function uploadImage($file, $user)
{
    //if no image dir
    if (!is_dir(__DIR__ . '/images')) {
        mkdir(__DIR__ . '/images');
    }

    //get filename extension
    $fileName = $file['name'];

    //search for dot in filename
    $dotPosition = strpos($fileName, '.');

    //take the substring from the dot position to the end of the string
    $extension = substr($fileName, $dotPosition + 1);

    //move image to image dir;
    move_uploaded_file($file['tmp_name'], __DIR__ . "/images/{$user['id']}.$extension");
    $updatedUser['extension'] = $extension;
    updateUser($updatedUser, $user['id']);
}

function putJson($users)
{
    file_put_contents(__DIR__ . '/users.json', json_encode($users, JSON_PRETTY_PRINT));
}

function validateUser($user, &$errors)
{
    $isValid = true;

    if (!$user['name']) {
        $isValid = false;
        $errors['name'] = 'Name is mandatory';
    }

    if (!$user['username'] || strlen($user['username']) < 6 || strlen($user['username']) > 16) {
        $isValid = false;
        $errors['username'] = 'Username is required and it must be less than 16 and greater than 6 chars';
    }

    if ($user['email'] && !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $errors['email'] = 'This must be a valid email address';
    }

    if (!filter_var($user['phone'], FILTER_VALIDATE_INT)) {
        $isValid = false;
        $errors['phone'] = 'This must be a valid phone number';
    }

    if (!$user['website']) {
        $errors['website'] = 'website is mandatory';
    }
    return $isValid;
}
