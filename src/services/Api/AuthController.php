<?php

// use Exception;

class AuthController
{
    private DatabaseConnector $databaseConnector;
    private UtilityService $utilityService;

    public function __construct()
    {
        require_once('src/services/DatabaseConnector.php');
        require_once('src/services/UtilityService.php');

        $this->databaseConnector = new DatabaseConnector();
        $this->utilityService = new UtilityService();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function validateLoginState(): bool
    {
        if (!isset($_COOKIE['LOGIN_TOKEN'])) {
            return false;
        }

        $databaseConnector = new DatabaseConnector();
        $result = $databaseConnector->selectOneRow("
                SELECT login_token FROM users
                WHERE login_token = " . $databaseConnector->escape($_COOKIE['LOGIN_TOKEN'])
        );
        if (empty($result)) {
            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function register(array $data = []): void
    {

        $result = [
            "uuid" => $this->utilityService->uuidV4(),
            "date_created" => date("Y-m-d H:i:s"),
            "email" => $this->databaseConnector->escape($data["email"]),
            "username" => $this->databaseConnector->escape($data["usertag"]),
            "password" => hash("sha256", $data["pass1"]),
            "label" => $this->databaseConnector->escape($data["username"]),
            "role" => "USER",
            "date_updated" => date("Y-m-d H:i:s")
        ];
        $this->databaseConnector->insert("users", $result);
    }

    /**
     * @param string $email
     * @return bool
     * @throws Exception
     */
    public function checkAvailibleRegistration(string $email): bool
    {
        $result = $this->databaseConnector->selectOneRow("
            SELECT email FROM users
            WHERE email = " . $email
        );
        if (!empty($result)) {
            return false;
        }
        return true;
    }
}