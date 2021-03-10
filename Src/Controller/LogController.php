<?php


include_once "DbController.php";
include_once "Model/DbCredentials.php";

class LogController
{

    //writes a log of the change into the DB
    public function createLog($query, $lastId)
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        $subString = substr($query, 0, 6);

        $tempResult = substr($query, strpos($query, '`') + 1, strlen($query));
        $tableName = substr($tempResult, 0, strpos($tempResult, '`'));

        if (!isset($_SESSION)) {
            session_start();
        }
        $sessionUsername = $_SESSION["username"];

        if($subString == "INSERT" || $subString == "UPDATE") {

            switch ($subString){

                case "INSERT":
                    $insertedValues = $this->getInsertedValues($query);

                    $insertedColumns = $this->getInsertedColumns($query);

                    for ($i = 0; $i < count($insertedColumns); $i++) {

                        $newValue = $insertedValues[$i];

                        if (strpos($insertedColumns[$i], "_fsid") !== false) {

                            $referenceTable = substr($insertedColumns[$i], 2, -6);

                            if ($referenceTable == "author") {

                                $statement = "SELECT `username` FROM `user` WHERE id=$insertedValues[$i]";

                                $result = mysqli_query($dbController->getDbConnection(), $statement);
                                $lookupValue = mysqli_fetch_array($result)["username"];

                            } elseif ($referenceTable == "group") {

                                $statement = "SELECT `name` FROM `groups` WHERE id=$insertedValues[$i]";

                                $result = mysqli_query($dbController->getDbConnection(), $statement);
                                $lookupValue = mysqli_fetch_array($result)["name"];

                            } elseif ($referenceTable == "role") {

                                $statement = "SELECT `name` FROM `roles` WHERE id=$insertedValues[$i]";

                                $result = mysqli_query($dbController->getDbConnection(), $statement);
                                $lookupValue = mysqli_fetch_array($result)["name"];

                            } else {

                                $statement = "SELECT `name` FROM `$referenceTable` WHERE id=$insertedValues[$i]";

                                $result = mysqli_query($dbController->getDbConnection(), $statement);
                                $lookupValue = mysqli_fetch_array($result)["name"];

                            }

                            $valueId = substr(trim($insertedValues[$i]), 1, -1);
                            $newValue = "'ID is $valueId references to $lookupValue'";

                        }

                        $statement = "INSERT INTO `logs` (`username`, `edited_table`, `edited_id`,`action`, `old_value`, `new_value`,
                            `row`) VALUES ('$sessionUsername','$tableName','$lastId','$subString','',$newValue, '$insertedColumns[$i]')";

                        mysqli_query($dbController->getDbConnection(), $statement);
                    }

                    break;


                case "UPDATE":

                    $updatedValues = $this->getUpdatedColumnValues($query);

                    error_log("#########################");
                    error_log($query);
                    error_log(var_dump($updatedValues));
                    error_log("#########################");


                    for ($i = 0; $i < count($updatedValues); $i++) {

                        $tempValue = explode("=",$updatedValues[$i]);

                        $column = trim($tempValue[0]);

                        $newValue = $tempValue[1];

                        $changes= $newValue;

                        $updatedId = $this->getUpdatedId($query);

                        error_log($updatedId);


                        if (strpos($column, "_fsid") !== false) {

                            $referenceTable = substr($column, 1, -6);

                            $valueId = trim($newValue);

                            if ($referenceTable == "group") {

                                $statement = "SELECT `name` FROM `groups` WHERE id=$newValue";

                                $result = mysqli_query($dbController->getDbConnection(), $statement);
                                $lookupValue = mysqli_fetch_array($result)["name"];

                            } elseif ($referenceTable == "role") {

                                $statement = "SELECT `name` FROM `roles` WHERE id=$newValue";

                                $result = mysqli_query($dbController->getDbConnection(), $statement);
                                $lookupValue = mysqli_fetch_array($result)["name"];

                            } else {

                                $statement = "SELECT `name` FROM `$referenceTable` WHERE id=$newValue";

                                error_log($statement);

                                $result = mysqli_query($dbController->getDbConnection(), $statement);
                                $lookupValue = mysqli_fetch_array($result)["name"];

                                error_log($lookupValue);

                                $valueId = substr(trim($newValue), 1, -1);

                            }

                            $changes = "'Updated ID is $valueId references to $lookupValue'";

                        }

                        $statement = "INSERT INTO `logs` (`username`, `edited_table`, `edited_id`,`action`, `old_value`, `new_value`,
                            `row`) VALUES ('$sessionUsername','$tableName','$updatedId','$subString','',$changes, '$column')";

                        error_log($statement);

                        mysqli_query($dbController->getDbConnection(), $statement);
                    }

                    break;

            }

        }

    }

    private function getInsertedValues($query)
    {
        $insertedValues = substr($query, strpos($query, "VALUES (") + 8, strlen($query));

        $insertedValues = substr($insertedValues, 0, strpos($insertedValues, ")"));

        return explode(",", $insertedValues);
    }

    private function getInsertedColumns($query)
    {
        $insertedColumns = substr($query, strpos($query, "(") + 1, strlen($query));

        $insertedColumns = substr($insertedColumns, 0, strpos($insertedColumns, ")"));

        return explode(",", $insertedColumns);
    }


    private function getUpdatedColumnValues($query)
    {
        $updatedColumnValues = substr($query, strpos($query, "SET") + 4, strlen($query));

        $updatedColumnValues = substr($updatedColumnValues, 0, strpos($updatedColumnValues, "WHERE")-1);

        return explode(",", $updatedColumnValues);
    }

    private function getUpdatedId($query)
    {

        $updatedId = substr($query, strpos($query, "WHERE") + 6, strlen($query));

        $id = explode("=", $updatedId)[1];

        return substr($id,1,-1);
    }

}