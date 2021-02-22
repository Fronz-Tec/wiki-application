<?php

include_once "DbController.php";
include_once "Model/DbCredentials.php";
class LinkController
{

    public function saveLink($linkURL,$linkName,$currentArticleId)
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        $statement = "INSERT INTO `links` (`article_fsid`, `title`, `url`) VALUES ('".$currentArticleId."', '".$linkName."', '".$linkURL."');";

        return $dbController->executeQuery($statement);



    }

    public function getAllLinksFromArticle($currentArticleId):array
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAllBy("links","article_fsid",$currentArticleId);

    }


}