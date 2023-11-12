<?php
function check_user($users, $inputName, $inputKey) {
    // Loop through the array returned by the query
    foreach ($users as $user) {
        if (
            ($user["names"] == strtolower($inputName) || $user["email"] == strtolower($inputName)) &&
            password_verify($inputKey,$user['pw']) 
        ) {
            return true;
        }
    }
    return false;
}