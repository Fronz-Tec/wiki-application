<?php
/*
 * A view for creating users
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
 * @since 18.02.21
 *
 */
?>


<div class='userCreationContainer'>
    <div class='container-fluid'>
        <form method='post' action="Controller/EventHandling.php" class="was-validated">

            <div class='row'>
                <div class='col-sm-12'>
                    <p class='menuTitle'>Add User</p>
                </div>
            </div>

            <div class='row' >

            <span class="col-sm-2">
                <input type="text" id="newUsername" name="newUsername" class="form-control"
                       placeholder="New User" required>

                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </span>

            <span class="col-sm-2">
                <div class="input-group">
                    <input type="password" id='passwordInput' name="newPassword" class="form-control"
                           placeholder="Password" required>

                    <a href='#' ><i class='fa fa-eye-slash' onclick='showPassword()' aria-hidden='true'></i></a>
                </div>

                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </span>

            <span class="col-sm-2">
                <input type="email" id="newEmail" name="newEmail" placeholder="Email" class="form-control" required>

                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </span>

            <input type="hidden" id="newUserHidden" name="newUserHidden">

            <span class='col-sm-2'>
                <div class="input-group mb-3">
                    <select id="roleSelect" name="roleSelect" class="custom-select" required>
                        <option value="" hidden>Select Role</option>
                        <?php
                        include_once "Controller/RoleController.php";

                        $roleController = new RoleController();
                        $roles = $roleController->getAllRoles();


                        foreach ($roles as $role){
                            echo "<option value='".$role["id"]."'>".$role["name"]."</option>";
                        }
                        ?>
                    </select>

                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please select a role.</div>
                </div>
            </span>

            <span class='col-sm-2'>
                <div class="input-group mb-3">
                    <select id="groupSelect" name="groupSelect" class="custom-select" required>
                        <option value="" hidden>Select Group</option>
                        <?php
                        include_once "Controller/GroupController.php";

                        $groupController = new GroupController();
                        $groups = $groupController->getAllGroups();


                        foreach ($groups as $group){
                            echo "<option value='".$group["id"]."'>".$group["name"]."</option>";
                        }
                        ?>
                    </select>

                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please select a group.</div>
                </div>
            </span>

            <span class='col-sm-2'>
                <button type="submit" class="btn btn-light">Save User</button>
            </span>
        </div>

    </form>
</div>
