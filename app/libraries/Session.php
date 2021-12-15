<?php
@session_start();
function isLoggedIn()
{
    return isset($_SESSION['user']);
}
function loginUser($user = null)
{
    if (!empty($user)) {
        @session_start();
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}
function logoutUser()
{
    if (isset($_SESSION['user'])) {
        session_destroy();
    } else {
        session_destroy();
    }
    return true;
}
