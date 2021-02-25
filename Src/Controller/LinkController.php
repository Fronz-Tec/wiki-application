<?php

/*
 * A Controller handling link functions
 *
 *
 * LICENSE:
 *
 * @category File
 * @package Src
 * @subpackage Controller
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 1.0
 * @link
 * @since 22.02.21
 *
 */

include_once "DbController.php";
include_once "Model/DbCredentials.php";
class LinkController
{

    public function saveLink($linkURL,$linkName,$currentArticleId)
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        $statement = "INSERT INTO `links` (`article_fsid`, `title`, `url`) VALUES ('".$currentArticleId."', 
        '".htmlspecialchars($linkName, ENT_QUOTES)."', '".htmlspecialchars($linkURL, ENT_QUOTES)."');";

        return $dbController->executeQuery($statement);

    }

    public function getAllLinksFromArticle($currentArticleId):array
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAllBy("links","article_fsid",$currentArticleId);

    }

}