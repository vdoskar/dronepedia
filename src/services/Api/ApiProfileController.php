<?php

class ApiProfileController
{
    private DatabaseConnector $databaseConnector;

    public function __construct()
    {
        $this->databaseConnector = new DatabaseConnector();
    }

    /**
     * @param string $uuid
     * @return array
     * @throws Exception
     */
    public function getUser(string $username): array
    {
        return $this->databaseConnector->selectOneRow("
            SELECT * FROM users_settings
            WHERE username = '" . $this->databaseConnector->escape($username) . "'"
        );
    }

    /**
     * @param string $uuid
     * @return array
     * @throws Exception
     */
    public function getUserSettings(string $uuid): array
    {
        return $this->databaseConnector->selectOneRow("
            SELECT * FROM users_settings
            WHERE user =  '" . $this->databaseConnector->escape($uuid) . "'"
        ) ?? [];
    }

    /**
     * @param string $uuid
     * @return array
     */
    public function getUserDrones(string $uuid): array
    {
        return [];
        return $this->databaseConnector->selectAll("
            SELECT * FROM users_drones
            WHERE user =  '" .$this->databaseConnector->escape($uuid) . "'"
        ) ?? [];
    }

    /**
     * @param string $uuid
     * @return array
     */
    public function getUserPosts(string $uuid): array
    {
        return [];
        return $this->databaseConnector->selectAll("
            SELECT * FROM posts
            WHERE user =  '" .$this->databaseConnector->escape($uuid) . "'"
        ) ?? [];
    }
}