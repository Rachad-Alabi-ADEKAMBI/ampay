<?php
require_once './src/model/back/admin/users.php';


function usersPage()
{
    require './src/view/back/admin/users.php';
}

function getAllUsers()
{
    fetchAllUsers();
}
