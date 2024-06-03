<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/UtilityService.php';

class ApiAuthController
{
    private DatabaseConnector $databaseConnector;
    private UtilityService $utilityService;
    private array $currentUser = [];
    private const MAX_LOGIN_ATTEMPTS = 5;

    public function __construct()
    {
        $this->databaseConnector = new DatabaseConnector();
        $this->utilityService = new UtilityService();
    }

    /**
     * Register a new user
     * @param array $data
     * @throws Exception
     */
    public function register(array $data = []): void
    {
        try {
            if (empty($data["pass1"]) || empty($data["email"]) || empty($data["usertag"]) || empty($data["username"])) {
                throw new Exception("Nebyly vyplněny všechny povinné údaje (email, uživatelské jméno, usertag, heslo).");
            }

            if ($data["pass1"] !== $data["pass2"]) {
                throw new Exception("Hesla se neshodují");
            }

            $registrationStatus = $this->checkAvailibleRegistration($data["email"], $data["usertag"]);
            if ($registrationStatus["status"] == "NOK") {
                throw new Exception($registrationStatus["message"]);
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

            $newUserSettings = [
                "user" => $result["uuid"],
                "pic_profile" => "https://cdn.dronepedia.krisp1k.eu/images/default_profile_picture.webp",
                "pic_banner" => "https://cdn.dronepedia.krisp1k.eu/images/default_profile_banner.webp",
                "bio" => "",
            ];

            $this->databaseConnector->insert(
                table: "users",
                data: $result
            );
            $this->databaseConnector->insert(
                table: "users_settings",
                data: $newUserSettings
            );
            $this->setLoggedUser($result["uuid"]);
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage());
            exit();
        }
    }

    /**
     * Login the user
     * @param array $data
     * @throws Exception
     */
    public function login(array $data = []): void
    {
        try {
            // nacteme udaje o uzivateli
            $result = $this->databaseConnector->selectOneRow(
                "
               SELECT * FROM users
               WHERE email = '" . $this->databaseConnector->escape($data["email"]) . "'"
            );
            if (empty($result)) {
                throw new Exception("Tento email neexistuje. Je potřeba se zaregistrovat.");
            }

            // zkontrolujeme jestli ma uzivatel zablokovane prihlaseni
            $failedLoginAttempts = intval($result["failed_login_attempts"]);
            if ($failedLoginAttempts >= $this::MAX_LOGIN_ATTEMPTS) {
                // zkontrolujeme, jestli vyprsel cas blokace
                if ($result["login_blocked_until"] >= date("Y-m-d H:i:s")) {
                    throw new Exception(
                        "Účet <b>" . $result["email"] . "</b> je zablokován kvůli neúspěšným pokusům o přihlášení.<br>Další možný pokus: <b>"
                        . date("H:i:s", strtotime($result["login_blocked_until"])) . "</b>");
                } else {
                    // pokud vyprsel cas blokace, zrusime blokaci
                    $failedLoginAttempts = 0;
                    $this->databaseConnector->update(
                        table: "users",
                        data: [
                            "failed_login_attempts" => $failedLoginAttempts,
                            "login_blocked_until" => null,
                        ],
                        conditionColumn: "uuid",
                        conditionValue: $result["uuid"]
                    );
                }
            }

            // zkontrolujeme heslo
            if (!$this->utilityService->areValuesEqual(
                $this->utilityService->hash($data["password"]),
                $result["password"],
            )) {
                // zvysime pocet neuspesnych pokusu o prihlaseni
                $failedLoginAttempts++;
                $this->databaseConnector->update(
                    table: "users",
                    data: [
                        "failed_login_attempts" => $failedLoginAttempts,
                        "login_blocked_until" => $failedLoginAttempts == $this::MAX_LOGIN_ATTEMPTS
                            ? date("Y-m-d H:i:s", strtotime("+5 minutes"))
                            : null
                        ,
                    ],
                    conditionColumn: "uuid",
                    conditionValue: $result["uuid"]
                );

                throw new Exception("Nesprávné heslo. Zkuste to znovu.");
            }

            // pokud vsechny testy projdou, vytvorime nove prihlaseni
            $this->setLoggedUser($result["uuid"]);
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage());
            exit();
        }
    }

    /**
     * Logout the user
     * @return void
     * @throws Exception
     */
    public function logout(): void
    {
        try {
            $this->databaseConnector->delete(
                table: "users_logged",
                conditionColumn: "session_token",
                conditionValue: $_COOKIE["SESSION_TOKEN"]
            );
            setcookie("SESSION_TOKEN", "", time() - 3600, "/");
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage());
            exit();
        }
    }

    /**
     * Check if user is logged in.
     * This is used for session validation in places where we don't need to work with the user data.
     * @return bool
     * @throws Exception
     */
    public function validateLogin(): bool
    {
        // test 1 - does the session token exist?
        $sessionToken = $_COOKIE["SESSION_TOKEN"] ?? "";
        if (empty($sessionToken)) {
            return false;
        }

        // test 2 - does a db record with this session token exist?
        $result = $this->databaseConnector->selectOneRow(
            "
            SELECT * FROM users_logged
            WHERE session_token = '" . $sessionToken . "'"
        );

        if (empty($result)) {
            $this->logout();
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
     * Validate the login and return the user data.
     * This is used in places where the user needs to be logged, and we need to work with the user data.
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

    /**
     * @param string $email
     * @param string $username
     * @return array
     * @throws Exception
     */
    private function checkAvailibleRegistration(string $email, string $username): array
    {
        $status = [];
        $emailRegistered = $this->databaseConnector->selectOneRow(
            "
            SELECT email FROM users
            WHERE email = '" . $this->databaseConnector->escape($email) . "'"
        );

        if (!empty($emailRegistered)) {
            $status["status"] = "NOK";
            $status["message"] = "Tento email je již registrován. Pokud jste zapomněli heslo, nemůžete si ho obnovit, ale můžete použít jinou emailovou adresu :).";
            return $status;
        }

        $usernameRegistered = $this->databaseConnector->selectOneRow(
            "
            SELECT username FROM users
            WHERE username = '" . $this->databaseConnector->escape($username) . "'"
        );

        if (!empty($usernameRegistered)) {
            $status["status"] = "NOK";
            $status["message"] = "Tento usertag je již obsazen. Vyberte si prosím jiný.";
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
            $sessionToken = $this->utilityService->hash($this->utilityService->uuidV4());
            $this->databaseConnector->insert(
                table: "users_logged",
                data: [
                    "session_token" => $sessionToken,
                    "logged_since" => date("Y-m-d H:i:s"),
                    "logged_until" => date("Y-m-d H:i:s", strtotime("+7 days")),
                    "user" => $userUUID
                ],
            );

            // upravime tabulku users
            $this->databaseConnector->update(
                table: "users",
                data: [
                    "date_last_login" => date("Y-m-d H:i:s"),
                    "failed_login_attempts" => 0,
                    "login_blocked_until" => null
                ],
                conditionColumn: "uuid",
                conditionValue: $userUUID
            );

            // set cookie
            setcookie("SESSION_TOKEN", $sessionToken, time() + 3600 * 24 * 7, "/");
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage());
            exit();
        }
    }
}