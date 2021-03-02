<?php
/*
 * A page for editing users
 *
 *
 * LICENSE:
 *
 * @category File
 * @package Src
 * @subpackage View
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 1.0
 * @link
 * @since 22.02.21
 *
 */


include_once "Controller/UserController.php";
include_once "Controller/RoleController.php";

$userController = new UserController();
$roleController = new RoleController();

?>

<div class='userCreationContainer'>
    <div class='container-fluid'>
        <form method='post' action='Controller/EventHandling.php' class='was-validated'>
        
            <div class='row'>
                <div class='col-sm-12'>
                    <p class='menuTitle'>Edit Profile</p>
                </div>
            </div>
            
            <div class='row' >
                <div class='col-sm-2'>
                    <?php

                        echo "<input type='text' name='username' value='".$_SESSION["username"]."' 
                              class='form-control' disabled>";

                    ?>
                </div>

                <!--ToDo: Load Password in box, Align Show Password Icon-->

                <div class='col-sm-2'>
                    <div class='input-group'>
                        <input type='password' name='changePassword' id='passwordInput' class='form-control' 
                        placeholder='password' required>
                    
                        <a href='#' ><i class='fa fa-eye-slash' onclick='showPassword()' aria-hidden='true'></i></a>
                    </div>
                    
                    <div class='valid-feedback'>Valid.</div>
                    <div class='invalid-feedback'>Please fill out this field to change your password.</div>
                </div>
            
                <div class='col-sm-2'>
                    <!--ToDo: Email Output-->
                    <div class='input-group mb-3'>
                        <select lass='custom-select' class='custom-select' disabled>
                            <option>coming soon</option>
                        </select>
                    </div>
                </div>

                <div class='col-sm-2'>
                    <div class='input-group mb-3'>
                        <select lass='custom-select' class='custom-select' disabled>
                            <?php

                                $userRoleId = $userController->getRoleOfUser();
                                $userRole = $roleController->getRoleName($userRoleId);

                                echo"<option>".$userRole."</option>";

                            ?>
                        </select>
                    </div>
                </div>

                <div class='col-sm-2'>
                    <button type='submit' class='btn btn-light'>Save Change</button>
                </div>

                <div class='col-sm-2'>

                </div>
            </div>
        </form>
    </div>
</div>

<hr class='menuDivider'>

<?php

if($userController->isAdmin()){

        $users = $userController->getAllUsers();
?>

<div class='userCreationContainer'>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-sm-12'>
                <p class='menuTitle'>Edit Users</p>
            </div>
        </div>

        <?php

            foreach ($users as $user){

        ?>

        <form method='post' action='Controller/EventHandling.php' class='was-validated'>

            <div class='row' >
                <div class='col-sm-2'>
                    <?php

                        echo "<input type='text' name='username' value='".$user["username"]."'
                              class='form-control' disabled>";

                    ?>
                </div>

                <div class='col-sm-2'>
                    <?php

                    echo "<input type='text' name='changePassword' id='changePassword' value='".$user["password"]."'
                    class='form-control' required>";

                    ?>
                    <div class='invalid-feedback'>Please fill out this field to change the password.</div>
                </div>

                <input type='hidden' name='editProfile' id='editProfile'>
                <?php

                    echo "<input type='hidden' name='userId' id='userId' value='".$user["id"]."'>";

                ?>
                <div class='col-sm-2'>
                    <?php

                        echo "<input type='text' value='".$user["mail"]."'  class='form-control' disabled>";

                    ?>
                </div>

                <div class='col-sm-2'>
                    <div class='input-group mb-3'>
                        <select name='role' class='custom-select'>
                            <?php

                                $roles = $roleController->getAllRoles();

                                foreach ($roles as $role){

                                    if($role["id"] == $user["role_fsid"]){
                                        echo "<option value='".$role["id"]."' selected>".$role["name"]."</option>";
                                    }else{
                                        echo "<option value='".$role["id"]."'>".$role["name"]."</option>";
                                    }
                                }

                            ?>
                        </select>
                    </div>

                    <div class='invalid-feedback'>Please select a role.</div>
                </div>

                <div class='col-sm-2'>
                    <button type='submit' class='btn btn-light'>Save Change</button>
                </div>

                <div class='col-sm-2'>

                </div>
            </div>
        </form>
<?php

        }

?>
    </div>
</div>

<?php

}

?>
