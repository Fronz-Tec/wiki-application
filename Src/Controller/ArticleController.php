<?php


include_once "DbController.php";
include_once "Model/DbCredentials.php";

class ArticleController
{



    public function getAllArticles(): array
    {

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAll("article");

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

        error_log("User Id: ".$value);


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

        $propertyName = mysqli_fetch_array($result)[$propertyRow];

        error_log("Result: ".$propertyName);
        return $propertyName;

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

        error_log("Autor Id: ".$authorId);

        $testVisibility = "4";

        error_log($title);
        error_log($text);
        error_log($category);

        //ToDo: Prevent SQL Injection

        $statement = "INSERT INTO `article` (`title`, `text`, `author_fsid`, `visibility_fsid`, `category_fsid`) VALUES ('".$title."', '".$text."', '".$authorId."', '".$testVisibility."', '".$category."'); ";

        error_log($statement);

        $dbCredentials = new \DbCredentials\DbCredentials();

        $dbController = new DbController($dbCredentials);

        $result = $dbController->executeQuery($statement);

        error_log($result);

        return $result;

    }


}