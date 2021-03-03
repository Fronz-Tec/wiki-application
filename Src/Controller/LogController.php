<?php


include_once "DbController.php";
include_once "Model/DbCredentials.php";

class LogController
{

    //writes a log of the change into the DB
    public function createLog($query)
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        $subString = substr($query,0,6);

        $tempResult = substr($query,strpos($query,'`')+1,strlen($query));
        $tableName = substr($tempResult,0,strpos($tempResult,'`'));

        if (!isset($_SESSION)) {
            session_start();
        }
        $sessionusername = $_SESSION["username"];

        switch ($subString){

            case "INSERT":
                //no old_value

                error_log("------------------------------------------------");
                $insertedValues = substr($query,strpos($query,"VALUES (")+8,strlen($query));
                error_log($insertedValues);
                $insertedValues = substr($insertedValues,0,strpos($insertedValues, ")"));
                error_log($insertedValues);
                $insertedValues = explode(",",$insertedValues);
                error_log($insertedValues);

                $insertedColumns= substr($query,strpos($query,"(")+1,strlen($query));
                error_log($insertedColumns);
                $insertedColumns = substr($insertedColumns,0,strpos($insertedColumns,")"));
                error_log($insertedColumns);
                $insertedColumns = explode(",",$insertedColumns);
                error_log($insertedColumns);


                $statement = "INSERT INTO `logs` (`username`, `edited_table`, `action`, `old_value`, `new_value`,
                    `row`) VALUES ('$sessionusername','$tableName','INSERT','',$insertedValues[1], '$insertedColumns[1]')";

                error_log($statement);
                error_log("------------------------------------------------");

                mysqli_query($dbController->getDbConnection(), $statement);

                break;

            case "UPDATE":

                break;

            case "DELETE":
                //no new_value

                break;

            default:

                break;

        }

    }

}