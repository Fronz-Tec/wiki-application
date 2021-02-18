<?php

?>


<div class="userCreationContainer">

    <form method="post" action="Controller/EventHandling.php">
        <input type="text" id="newUsername" name="newUsername" placeholder="New User" required>
        <input type="text" id="newPassword" name="newPassword" placeholder="Password" required>
        <input type="email" id="newEmail" name="newEmail" placeholder="Email" required>
        <input type="hidden" id="newUserHidden" name="newUserHidden">
        <select id="roleSelect" name="roleSelect">
            <?php
            include_once "Controller/RoleController.php";

            $roleController = new RoleController();
            $roles = $roleController->getAllRoles();


            foreach ($roles as $role){
                echo "<option value='".$role["id"]."'>".$role["name"]."</option>";
            }
            ?>
        </select>
        <select id="groupSelect" name="groupSelect">
            <?php
            include_once "Controller/GroupController.php";

            $groupController = new GroupController();
            $groups = $groupController->getAllGroups();


            foreach ($groups as $group){
                echo "<option value='".$group["id"]."'>".$group["name"]."</option>";
            }
            ?>
        </select>

        <button type="submit">Save new USer</button>
    </form>

</div>
