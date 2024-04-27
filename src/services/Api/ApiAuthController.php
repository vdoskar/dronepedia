<?php

// use Exception;

class ApiAuthController
{
    private DatabaseConnector $databaseConnector;
    private UtilityService $utilityService;

    private array $currentUser = [];

    public function __construct()
    {
        require_once 'src/services/DatabaseConnector.php';
        require_once 'src/services/UtilityService.php';

        $this->databaseConnector = new DatabaseConnector();
        $this->utilityService = new UtilityService();
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function register(array $data = []): void
    {
        if ($data["pass1"] !== $data["pass2"]) {
            throw new Exception("Passwords do not match");
        }

        $registrationStatus = $this->checkAvailibleRegistration($data["email"], $data["usertag"]);
        if ($registrationStatus["status"] === "NOK") {
            throw new Exception($registrationStatus["message"], 400);
        }

        $result = [
            "uuid" => $this->utilityService->uuidV4(),
            "date_created" => date("Y-m-d H:i:s"),
            "email" => $this->databaseConnector->escape($data["email"]),
            "username" => $this->databaseConnector->escape($data["usertag"]),
            "password" => $this->utilityService->hash($data["pass1"]),
            "label" => $this->databaseConnector->escape($data["username"]),
            "role" => "USER",
            "date_updated" => date("Y-m-d H:i:s")
        ];
        try {
            $this->databaseConnector->insert("users", $result);
            $this->setLoggedUser($result["uuid"]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function login(array $data = []): void
    {
       try {
           $result = $this->databaseConnector->selectOneRow("
                SELECT * FROM users
                WHERE email = '" . $this->databaseConnector->escape($data["email"]) . "' 
                AND password = '" . $this->utilityService->hash($data["password"]) . "'"
           );
           if (empty($result)) {
               throw new Exception("Invalid email or password");
           }

           $this->setLoggedUser($result["uuid"]);
       } catch (Exception $e) {
           throw new Exception($e->getMessage());
       }
    }

    /**
     * @param string $email
     * @param string $username
     * @return array
     * @throws Exception
     */
    public function checkAvailibleRegistration(string $email, string $username): array
    {
        $status = [];
        $emailRegistered = $this->databaseConnector->selectOneRow("
            SELECT email FROM users
            WHERE email = '" . $this->databaseConnector->escape($email) . "'"
        );

        if (!empty($emailRegistered)) {
            $status["status"] = "NOK";
            $status["message"] = "Email is already registered";
            return $status;
        }

        $usernameRegistered = $this->databaseConnector->selectOneRow("
            SELECT username FROM users
            WHERE username = '" . $this->databaseConnector->escape($username) . "'"
        );

        if (!empty($usernameRegistered)) {
            $status["status"] = "NOK";
            $status["message"] = "Email is already registered";
            return $status;
        }

        $status["status"] = "OK";
        return $status;
    }

    /**
     * @param string|null $userUUID
     * @throws Exception
     */
    public function setLoggedUser(string $userUUID = null): void
    {
        try {
            $loginToken = $this->utilityService->uuidV4();
            $this->databaseConnector->insert(
                "users_logged",
                [
                    "session_token" => $loginToken,
                    "logged_since" => date("Y-m-d H:i:s"),
                    "user" => $userUUID
                ],
            );
            setcookie("SESSION_ID", $loginToken, time() + 3600 * 24, "/");

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function logout(): void
    {
       try {
           $this->databaseConnector->delete(
               "users_logged",
               "session_token",
               $_COOKIE["SESSION_ID"]
           );
           setcookie("SESSION_ID", "", time() - 3600, "/");
       } catch (Exception $e) {
           throw new Exception($e->getMessage());
       }
    }

    /**
     * @param string $sessionToken
     * @return bool
     * @throws Exception
     */
    public function validateLogin(string $sessionToken): bool
    {
        $result = $this->databaseConnector->selectOneRow("
            SELECT * FROM users_logged
            WHERE session_token = '" . $sessionToken . "'"
        );
        if (empty($result)) {
            return false;
        }

        // save for local use
        $this->currentUser = $this->databaseConnector->selectOneRow("
            SELECT * FROM users
            WHERE uuid = '" . $result["user"] . "'"
        );
        return true;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCurrentUser(): array
    {
        if (!isset($_COOKIE["SESSION_ID"])) {
            return [];
        }

       return $this->currentUser;
    }
}