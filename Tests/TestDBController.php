<?php

use PHPUnit\Framework\TestCase;

require "../Src/Controller/DbController.php";
require "../Src/Model/DbCredentials.php";


class TestDBController extends TestCase
{

    public function test_connect()
    {
        $dbController = new DbController($this->get_test_db_credentials());

        $this->assertTrue(
            $dbController->isConnected(),
            "TestDB could connect"
        );

    }

    public function test_create_tables()
    {

        $this->drop_tables();

        $dbController = new DbControler($this->get_test_db_credentials());
        $connection = $dbController->get_connection();

        $sql_query_check_article = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'article' LIMIT 1;";
        $sql_query_check_category = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'category' LIMIT 1;";
        $sql_query_check_groups = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'groups' LIMIT 1;";
        $sql_query_check_links = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'links' LIMIT 1;";
        $sql_query_check_roles = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'roles' LIMIT 1;";
        $sql_query_check_user = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'user' LIMIT 1;";
        $sql_query_check_visibility = "SELECT * FROM information_schema.tables WHERE table_schema = 'test_wiki' 
                                          AND table_name = 'visibility' LIMIT 1;";

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sql_query_check_article)) == 1,
            "Table article does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sql_query_check_category)) == 1,
            "Table category does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sql_query_check_groups)) == 1,
            "Table groups does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sql_query_check_links)) == 1,
            "Table links does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sql_query_check_roles)) == 1,
            "Table roles does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sql_query_check_user)) == 1,
            "Table user does not exist"
        );

        $this->assertTrue(
            mysqli_num_rows(mysqli_query($connection, $sql_query_check_visibility)) == 1,
            "Table visibility does not exist"
        );

    }


    private function create_connection()
    {
        $tmp_cred = $this->get_test_db_credentials()->get_credentials();
        return $this->connection = mysqli_connect(
            $tmp_cred["DB_SERVER"],
            $tmp_cred["DB_USERNAME"],
            $tmp_cred["DB_PASSWORD"],
            $tmp_cred["DB_NAME"]
        );
    }

    private function drop_tables():void
    {

        $sql_query_drop_article = "DROP TABLE article FROM test_wiki";
        $sql_query_drop_category = "DROP TABLE category FROM test_wiki";
        $sql_query_drop_groups = "DROP TABLE groups FROM test_wiki";
        $sql_query_drop_links = "DROP TABLE links FROM test_wiki";
        $sql_query_drop_roles = "DROP TABLE roles FROM test_wiki";
        $sql_query_drop_user = "DROP TABLE user FROM test_wiki";
        $sql_query_drop_visibility = "DROP TABLE visibility FROM test_wiki";

        $connection = $this->create_connection();

        mysqli_query($connection,$sql_query_drop_article);
        mysqli_query($connection,$sql_query_drop_category);
        mysqli_query($connection,$sql_query_drop_groups);
        mysqli_query($connection,$sql_query_drop_links);
        mysqli_query($connection,$sql_query_drop_roles);
        mysqli_query($connection,$sql_query_drop_user);
        mysqli_query($connection,$sql_query_drop_visibility);

    }

    private function clear_tables():void
    {
        $sql_query_clear_article = "DELETE FROM article";
        $sql_query_clear_category = "DELETE FROM category";
        $sql_query_clear_auth_groups = "DELETE FROM groups";
        $sql_query_clear_auth_links = "DELETE FROM links";
        $sql_query_clear_auth_roles = "DELETE FROM roles";
        $sql_query_clear_auth_user = "DELETE FROM user";
        $sql_query_clear_auth_visibility = "DELETE FROM visibility";

        $connection = $this->create_connection();

        mysqli_query($connection,$sql_query_clear_article);
        mysqli_query($connection,$sql_query_clear_category);
        mysqli_query($connection,$sql_query_clear_auth_groups);
        mysqli_query($connection,$sql_query_clear_auth_links);
        mysqli_query($connection,$sql_query_clear_auth_roles);
        mysqli_query($connection,$sql_query_clear_auth_user);
        mysqli_query($connection,$sql_query_clear_auth_visibility);

    }

    private function get_test_db_credentials():DbCredentials
    {
        $dbCredentialMock = $this->createMock(DbCredentials::class);
        $dbCredentialMock->method('get_credentials')
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