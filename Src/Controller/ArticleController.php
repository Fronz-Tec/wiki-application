<?php


include_once "DbController.php";
include_once "Model/DbCredentials.php";

include_once "SessionController.php";
include_once "UserController.php";


class ArticleController
{



    public function getAllArticles(): array
    {

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAll("article");

    }

    public function getArticleById($id): array{

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAllBy("article","id",$id);

    }


    public function getAllArticlesByVisibility($visibility):array
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAllBy("article","visibility_fsid",$visibility);

    }

    public function getAllArticlesByAuthor($author):array
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAllBy("article","author_fsid",$author);

    }



    public function getAllByOwn():array
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        $username = $_SESSION["username"];

        $statement = "Select id FROM user WHERE username ='".$username."'";

        $tempResult = $dbController->executeQuery($statement);

        $value = mysqli_fetch_assoc($tempResult)["id"];

        return $dbController->getAllBy("article","author_fsid",$value);

    }

    public function getAllArticlesByCategory($category):array
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAllBy("article","category_fsid",$category);

    }


    public function getArticleCategory($articleId): string
    {

        return $this->getArticleInfo($articleId,"category_fsid","name","category");

    }

    public function getArticleAuthor($articleId): string
    {

        return $this->getArticleInfo($articleId,"author_fsid","username","user");

    }

    public function getArticleVisibility($articleId): string
    {

        return $this->getArticleInfo($articleId,"visibility_fsid","name","visibility");

    }

    public function getArticleInfo($articleId, $articlePropertyName, $propertyRow, $propertyTable): string
    {
        $statement = "SELECT ".$articlePropertyName." FROM article WHERE id = '".$articleId."'";

        $dbCredentials = new \DbCredentials\DbCredentials();

        $dbController = new DbController($dbCredentials);

        $result = $dbController->executeQuery($statement);

        $propertyId = mysqli_fetch_array($result)[$articlePropertyName];

        $statement = "SELECT ".$propertyRow." FROM ".$propertyTable." WHERE id ='".$propertyId."'";

        $result = $dbController->executeQuery($statement);

        return mysqli_fetch_array($result)[$propertyRow];

    }

    //ToDo: Make Article Creation
    public function saveArticleInDb($title,$text, $category){

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        session_start();

        $username = $_SESSION["username"];

        $statement = "Select id FROM user WHERE username ='".$username."'";
        $tempResult = $dbController->executeQuery($statement);

        $authorId = mysqli_fetch_assoc($tempResult)["id"];

        $testVisibility = "2";

        //ToDo: Prevent SQL Injection

        $statement = "INSERT INTO `article` (`title`, `text`, `author_fsid`, `visibility_fsid`, `category_fsid`) VALUES ('".$title."', '".$text."', '".$authorId."', '".$testVisibility."', '".$category."'); ";

        $dbCredentials = new \DbCredentials\DbCredentials();

        $dbController = new DbController($dbCredentials);

        $result = $dbController->executeQuery($statement);
//
//        error_log($result);

        return $result;

    }

    public function updateArticleInDb($id,$title,$text, $category, $visibility)
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        $statement = "UPDATE `article` SET `title`='".$title."',`text`='".$text."', `visibility_fsid`='".$visibility."', `category_fsid`='".$category."' WHERE `id`='".$id."'";

        error_log($statement);

        return $dbController->executeQuery($statement);
    }



    public function hasPermissionToEdit($articleId):bool
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);
        $sessionController = new SessionController();

        $hasPermission = false;

        error_log("called hasPermissionToEdit");

        //checks if the session wasn't manipulated
        if($sessionController->verifySession()){

            $userController = new UserController();

            if($userController->isAdmin() || $userController->isCurator()){
                error_log("User has edit rights");
                $hasPermission = true;
            }else{

                $username = $_SESSION["username"];

                $statement = "Select id FROM `user` WHERE username ='".$username."'";
                $tempResult = $dbController->executeQuery($statement);

                $userId = mysqli_fetch_assoc($tempResult)["id"];

               $statement = ("SELECT * FROM `article` WHERE `id`=".$articleId." AND `author_fsid`=".$userId);

               error_log($statement);

                $result = $dbController->executeQuery($statement);

                //is author
                if ($result->num_rows == 1) {
                    $hasPermission = true;
                }

            }

        }else{
            $hasPermission = false;
        }

        return $hasPermission;

    }


}