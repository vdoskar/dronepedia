<?php

class ApiProfileController
{
    private DatabaseConnector $databaseConnector;
    private ApiAuthController $authController;
    private UtilityService $utilityService;


    public function __construct()
    {
        require_once 'src/services/DatabaseConnector.php';
        require_once 'src/services/Api/ApiAuthController.php';
        require_once 'src/services/UtilityService.php';

        $this->databaseConnector = new DatabaseConnector();
        $this->authController = new ApiAuthController();
        $this->utilityService = new UtilityService();
    }

    /**
     * @param string $newPassword
     * @return void
     * @throws Exception
     */
    public function changePassword(string $newPassword): void
    {
        $this->databaseConnector->update("users",
            [
                "password" => $this->utilityService->hash($newPassword)
            ],
            "uuid",
            $this->authController->getCurrentUser()["uuid"]
        );
    }

    /**
     * @param string $newEmail
     * @return void
     * @throws Exception
     */
    public function changeEmail(string $newEmail): void
    {
        $this->databaseConnector->update("users",
            [
                "email" => $this->databaseConnector->escape($newEmail)
            ],
            "uuid",
            $this->authController->getCurrentUser()["uuid"]
        );
    }


    /**
     * @param array $newSettings
     * @return void
     * @throws Exception
     */
    public function changeSettings(array $newSettings): void
    {
        if (empty($newSettings["avatar"]) &&
            empty($newSettings["banner"]) &&
            empty($newSettings["bio"])
        ) {
           return;
        }

        $currentUser = $this->authController->getCurrentUser() ?? [];
        if (empty($currentUser)) {
            throw new Exception("Pro změnu nastavení se musíte přihlásit.");
        }

        $result = [
            "user" => $currentUser["uuid"],
            "pic_profile" => $this->databaseConnector->escape($newSettings["avatar"]),
            "pic_banner" => $this->databaseConnector->escape($newSettings["banner"]),
            "bio" => $this->databaseConnector->escape($newSettings["bio"]),
        ];

        $settings = $this->getUserSettings($currentUser["uuid"]);
        try {
            if (empty($settings)) {
                $this->databaseConnector->insert("users_settings", $result);
            } else {
                $this->databaseConnector->update("users_settings", $result, "user", $currentUser["uuid"]);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $username
     * @return array
     * @throws Exception
     */
    public function getUserByUsername(string $username): array
    {
        return $this->databaseConnector->selectOneRow("
            SELECT * FROM users
            WHERE username = '" . $this->databaseConnector->escape($username) . "'"
        ) ?? [];
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