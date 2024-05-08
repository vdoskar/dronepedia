<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/UtilityService.php';

class ApiAuthController
{
    private DatabaseConnector $databaseConnector;
    private UtilityService $utilityService;

    private array $currentUser = [];

    public function __construct()
    {
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
            "date_registered" => date("Y-m-d H:i:s"),
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
           // zkontrolujeme jestli uzivatel existuje
           $result = $this->databaseConnector->selectOneRow("
                SELECT * FROM users
                WHERE email = '" . $this->databaseConnector->escape($data["email"]) . "' 
                AND password = '" . $this->utilityService->hash($data["password"]) . "'"
           );
           if (empty($result)) {
               throw new Exception("Invalid email or password");
           }

           // vytvorime nove prihlaseni
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
    private function setLoggedUser(string $userUUID = null): void
    {
        try {
            if (!empty($userUUID)) {
                // smazeme pripadne stare prihlaseni
                $this->databaseConnector->delete(
                    table: "users_logged",
                    conditionColumn: "user",
                    conditionValue: $userUUID
                );
            }

            // vytvorime novy token a nove prihlaseni pro uzivatele
            $loginToken = $this->utilityService->uuidV4();
            $this->databaseConnector->insert(
                table: "users_logged",
                data: [
                    "session_token" => $loginToken,
                    "logged_since" => date("Y-m-d H:i:s"),
                    "logged_until" => date("Y-m-d H:i:s", strtotime("+7 days")),
                    "user" => $userUUID
                ],
            );
            // last login
            $this->databaseConnector->update(
                table: "users",
                data: ["date_last_login" => date("Y-m-d H:i:s")],
                conditionColumn: "uuid",
                conditionValue: $userUUID
            );
            setcookie("SESSION_ID", $loginToken, time() + 3600 * 24 * 7, "/");

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
               table: "users_logged",
               conditionColumn: "session_token",
               conditionValue: $_COOKIE["SESSION_ID"]
           );
           setcookie("SESSION_ID", "", time() - 3600, "/");
       } catch (Exception $e) {
           throw new Exception($e->getMessage());
       }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function validateLogin(): bool
    {
        // test 1 - does the session token exist?
        $sessionToken = $_COOKIE["SESSION_ID"] ?? "";
        if (empty($sessionToken)) {
            return false;
        }

        // test 2 - does a db record with this session token exist?
        $result = $this->databaseConnector->selectOneRow("
            SELECT * FROM users_logged
            WHERE session_token = '" . $sessionToken . "'"
        );
        if (empty($result)) {
            return false;
        }

        // test 3 - is the session token expired?
        if ($result["logged_until"] < date("Y-m-d H:i:s")) {
            $this->logout();
            return false;
        }

        // save for local use
        $this->currentUser = $this->databaseConnector->selectOneRow("
            SELECT * FROM users
            WHERE uuid = '" . $this->databaseConnector->escape($result["user"]) . "'"
        );

        return true;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getCurrentUser(): array
    {
        if (!$this->validateLogin()) {
            return [];
        }

        return $this->currentUser;
    }
}