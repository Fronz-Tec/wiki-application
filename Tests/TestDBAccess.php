<?php

/*
 * Unit Test for everything about data manipulation
 *
 *
 * LICENSE:
 *
 * @category Test
 * @package Test
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 1.0
 * @link
 * @since 23.02.21
 *
 */

use PHPUnit\Framework\TestCase;

require "../Src/Controller/DbController.php";
require "../Src/Model/DbCredentials.php";

require "../Src/Controller/ArticleController.php";
require "../Src/Controller/LinkController.php";


class TestDBAccess extends TestCase
{

    public function testConnect()
    {
        $dbController = new DbController($this->getTestDbCredentials());

        $this->assertTrue(
            $dbController->isConnected(),
            "TestDB could not connect"
        );

    }

    public function testCreateTables()
    {
        $this->dropTables();

        $dbController = new DbController($this->getTestDbCredentials());
        $connection = $dbController->getDbConnection();

        //$dbController->createDbTables();


        $sqlQueryCheckArticle = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                       AND table_name = 'article' LIMIT 1;";
        $sqlQueryCheckCategory = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'category' LIMIT 1;";
        $sqlQueryCheckGroups = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'groups' LIMIT 1;";
        $sqlQueryCheckLinks = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'links' LIMIT 1;";
        $sqlQueryCheckRoles = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'roles' LIMIT 1;";
        $sqlQueryCheckUser = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'user' LIMIT 1;";
        $sqlQueryCheckVisibility = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'visibility' LIMIT 1;";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckArticle)) == 1,
            "Table article does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckCategory)) == 1,
            "Table category does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckGroups)) == 1,
            "Table groups does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckLinks)) == 1,
            "Table links does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckRoles)) == 1,
            "Table roles does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckUser)) == 1,
            "Table user does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckVisibility)) == 1,
            "Table visibility does not exist"
        );
    }


    public function testSaveUser()
    {
        $dbController = new DbController($this->getTestDbCredentials());
        $userController = new UserController();
        $connection = $dbController->getDbConnection();

        $sqlQueryClearUser = "DELETE FROM `user`";

        mysqli_query($connection,$sqlQueryClearUser);

        $sqlQueryCheckUser = "SELECT * FROM `user`";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckUser)) == 0,
            "User Table not empty"
        );

        $userController->createNewUser("testUserName","test@test.test","testPassword",
            "1","1");

        $sqlQueryCheckNewUser = "SELECT * FROM `user` WHERE `username`='testuserName' ";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckNewUser)) == 1,
            "No new user"
        );

    }



    public function testUpdateUser()
    {

        $dbController = new DbController($this->getTestDbCredentials());
        $userController = new UserController();
        $connection = $dbController->getDbConnection();

        $sqlQueryCheckUser = "SELECT * FROM `user` WHERE username='admin'";

        //admin user should exist in DB after Connecting
        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckUser)) == 1,
            "User Table empty"
        );

        $oldPassword = mysqli_fetch_array(mysqli_query($connection, $sqlQueryCheckUser))["password"];

        $userController->updateUser("newPassword",1,
            mysqli_fetch_assoc(mysqli_query($connection, $sqlQueryCheckUser))["id"]);


        $this->assertFalse(
            mysqli_fetch_array(mysqli_query($connection, $sqlQueryCheckUser))["password"] == $oldPassword,
            "password is still same"
        );

    }


    public function testCreateArticle()
    {
        $sqlQueryClearArticle = "DELETE FROM article";

        $dbController = new DbController($this->getTestDbCredentials());
        $articleController = new ArticleController();
        $connection = $dbController->getDbConnection();

        mysqli_query($connection,$sqlQueryClearArticle);

        $sqlQueryCheckArticle = "SELECT * FROM article";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckArticle)) == 0,
            "Article Table not empty"
        );

        $sqlQueryCheckUserAdmin = "SELECT * FROM `user`";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckUserAdmin)) >= 1,
            "users are empty"
        );


        //admin User should exist in DB, therefore name is valid
        $_SESSION["username"] = "admin";

        $createArticle = $articleController->saveArticleInDb("Test","This is a test","1","1");

        mysqli_query($connection,$createArticle);

        //If successful, the article should exist in DB, else empty
        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckArticle)) == 1,
            "Article Table empty"
        );
    }

    public function testUpdateArticle()
    {
        $sqlQueryClearArticle = "DELETE FROM article";

        $dbController = new DbController($this->getTestDbCredentials());
        $articleController = new ArticleController();
        $connection = $dbController->getDbConnection();

        mysqli_query($connection,$sqlQueryClearArticle);

        $sqlQueryCheckArticle = "SELECT * FROM article";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckArticle)) == 0,
            "Article Table not empty"
        );

        $createArticle = "INSERT INTO `article` (`id`, `date`, `title`, `text`, `author_fsid`, `visibility_fsid`, 
                       `category_fsid`) VALUES (999, current_timestamp(), 'test', 'test', '1', '1', '1')";

        mysqli_query($connection,$createArticle);

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckArticle)) == 1,
            "Article Table empty"
        );

        $updateArticle = $articleController->updateArticleInDb(999,"Updated Test","This is an updated test",
        "1","1");

        mysqli_query($connection,$updateArticle);

        $sqlQueryCheckUpdate = "SELECT * FROM `article` WHERE `title`='Updated Test' 
                          AND `text`='This is an updated test'";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckUpdate)) == 1,
            "Article Table empty"
        );
    }



    public function testCreateLink()
    {
        $dbController = new DbController($this->getTestDbCredentials());
        $linkController = new LinkController();
        $connection = $dbController->getDbConnection();

        $sqlQueryClearArticle = "DELETE FROM `article`";
        mysqli_query($connection,$sqlQueryClearArticle);

        $sqlQueryCheckArticle = "SELECT * FROM `article`";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckArticle)) == 0,
            "Article Table not empty"
        );

        $sqlQueryDeleteLinks = "DELETE FROM `links`";
        mysqli_query($connection,$sqlQueryDeleteLinks);

        $sqlQueryCheckLink = "SELECT * FROM `links`";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckLink)) == 0,
            "Link Table not empty"
        );

        $createArticle = "INSERT INTO `article` (`id`, `date`, `title`, `text`, `author_fsid`, `visibility_fsid`, 
                       `category_fsid`) VALUES (999, current_timestamp(), 'test', 'test', '1', '1', '1')";

        mysqli_query($connection,$createArticle);

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckArticle)) == 1,
            "Article Table is empty"
        );

        $newLink = $linkController->saveLink("http://test.link","Test Link",999);

        mysqli_query($connection,$newLink);

        $sqlQueryCheckUpdate = "SELECT * FROM `links` WHERE `article_fsid`=999 
                          AND `title`='Test Link' AND `url`='http://test.link'";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sqlQueryCheckUpdate)) == 1,
            "Link not created"
        );

    }











    private function createConnection()
    {
        $tmp_cred = $this->getTestDbCredentials()->getCredentials();
        return $this->connection = new mysqli(
            $tmp_cred["DB_SERVER"],
            $tmp_cred["DB_USERNAME"],
            $tmp_cred["DB_PASSWORD"],
            $tmp_cred["DB_NAME"]
        );
    }

    private function dropTables():void
    {

        $sqlQueryDropArticle = "DROP TABLE `article`";
        $sqlQueryDropCategory = "DROP TABLE category";
        $sqlQueryDropGroups = "DROP TABLE groups";
        $sqlQueryDropLinks = "DROP TABLE links";
        $sqlQueryDropRoles = "DROP TABLE roles";
        $sqlQueryDropUser = "DROP TABLE user";
        $sqlQueryDropVisibility = "DROP TABLE visibility";

        $connection = $this->createConnection();

        mysqli_query($connection,$sqlQueryDropArticle);
        mysqli_query($connection,$sqlQueryDropCategory);
        mysqli_query($connection,$sqlQueryDropGroups);
        mysqli_query($connection,$sqlQueryDropLinks);
        mysqli_query($connection,$sqlQueryDropRoles);
        mysqli_query($connection,$sqlQueryDropUser);
        mysqli_query($connection,$sqlQueryDropVisibility);

    }

    private function getTestDbCredentials():DbCredentials
    {
        $dbCredentialMock = $this->createMock(DbCredentials::class);
        $dbCredentialMock->method('getCredentials')
            ->willReturn(
                array(
                    "DB_SERVER" => 'localhost',
                    "DB_USERNAME" => 'testWikiUser',
                    "DB_PASSWORD" => 'testWikiPassword',
                    "DB_NAME" => 'test_wiki',
                )
            );

        return $dbCredentialMock;
    }





}