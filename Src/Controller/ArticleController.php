<?php


include_once "DbController.php";
include_once "Model/DbCredentials.php";

class ArticleController
{

    public function getAllArticles(): array{

        $statement = "SELECT * FROM article";

        $dbCredentials = new \DbCredentials\DbCredentials();

        $dbController = new DbController($dbCredentials);

        $tempResult = $dbController->executeQuery($statement);

        $result = array();

        while ($article = mysqli_fetch_array($tempResult)) {

            array_push($result, $article);

        }

//        var_dump($result);

        return $result;

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


}