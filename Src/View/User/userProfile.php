<?php

include_once "Controller/UserController.php";
include_once "Controller/RoleController.php";

$userController = new UserController();
$roleController = new RoleController();

$currentUserRole = $userController->getRoleOfUser();
$currentUserId = $userController->getUserId();


echo"
<form method='post' action='Controller/EventHandling.php'>
    <input type='text' name='username' value='".$_SESSION["username"]."' disabled>
    <input type='password' name='changePassword' id='changePassword' placeholder='password'>
    <input type='hidden' name='userId' id='userId' value='".$currentUserId."'>
    <input type='hidden' name='role' id='role' value='".$currentUserRole."'>
    <button type='submit'>Save Changes</button>
</form>";

if($userController->isAdmin()){

    $users = $userController->getAllUsers();

    echo "<div>";

    foreach ($users as $user){
        echo "<div class='row' >
            <form method='post' action='Controller/EventHandling.php'> 
            
            <span class='col-sm-2'>
                <input type='text' name='username' value='".$user["username"]."' disabled>
            </span>
            
            <span class='col-sm-2'>
                <input type='text' name='changePassword' id='changePassword' value='".$user["password"]."'>
            </span>
            
            <input type='hidden' name='editProfile' id='editProfile'>
            
            <input type='hidden' name='userId' id='userId' value='".$user["id"]."'>
            
            <span class='col-sm-2'>
                 <input type='text' value='".$user["mail"]."' disabled>
            </span>
            
            <span class='col-sm-3'>
                <select name='role'>";

                $roles = $roleController->getAllRoles();

                foreach ($roles as $role){
                    echo "<option value='".$role["id"]."'>".$role["name"]."</option>";
                }


        echo "</select>
            </span>
            
            <span class='col-sm-3'>
                <button type='submit'>save Change</button>
            </span>

        </form>
        </div>";
    }

    echo "</div>";



}

?>