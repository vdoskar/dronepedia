<?php

require_once 'src/services/DatabaseConnector.php';
require_once 'src/services/Api/ApiAuthController.php';
require_once 'src/services/UtilityService.php';

class ApiProfileController
{
    private DatabaseConnector $databaseConnector;
    private ApiAuthController $authController;
    private UtilityService $utilityService;

    public function __construct()
    {
        $this->databaseConnector = new DatabaseConnector();
        $this->authController = new ApiAuthController();
        $this->utilityService = new UtilityService();
    }

    /**
     * Get user data by username
     * @param string $username
     * @return array
     * @throws Exception
     */
    public function getUserByUsername(string $username): array
    {
        return $this->databaseConnector->selectOneRow(
            "
            SELECT * FROM users
            WHERE username = '" . $this->databaseConnector->escape($username) . "'"
        ) ?? [];
    }

    /**
     * Get user profile settings by UUID of the user
     * @param string $uuid
     * @return array
     * @throws Exception
     */
    public function getUserSettings(string $uuid): array
    {
        return $this->databaseConnector->selectOneRow(
            "
            SELECT * FROM users_settings
            WHERE user =  '" . $this->databaseConnector->escape($uuid) . "'"
        ) ?? [];
    }

    /**
     * Get user drones by UUID of the user
     * @param string $uuid
     * @return array
     */
    public function getUserDrones(string $uuid): array
    {
        $list = $this->databaseConnector->selectAll(
            "
            SELECT * FROM users_drones
            WHERE owner =  '" . $this->databaseConnector->escape($uuid) . "'"
        );

        if (empty($list)) {
            return [];
        }

        // normalize drone params
        foreach ($list as $i => $item) {
            $list[$i]["drone_params"] = json_decode($item["drone_params"], true) ?? [];
        }

        return $list;
    }

    /**
     * Get user posts by UUID of the user
     * @param string $uuid
     * @return array
     */
    public function getUserPosts(string $uuid): array
    {
        return $this->databaseConnector->selectAll(
            "
            SELECT * FROM posts
            WHERE author =  '" . $this->databaseConnector->escape($uuid) . "'"
        ) ?? [];
    }

    /**
     * Get user comments by UUID of the user
     * @param string $uuid
     * @return array
     */
    public function getUserComments(string $uuid): array
    {
        return $this->databaseConnector->selectAll(
            "
            SELECT * FROM posts_comments
            WHERE author =  '" . $this->databaseConnector->escape($uuid) . "'"
        ) ?? [];
    }

    /**
     * Change the email of the current user
     * @param string $newEmail
     * @return void
     * @throws Exception
     */
    public function changeEmail(string $newEmail): void
    {
        try {
            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro změnu emailu se musíte přihlásit.");
            }

            $this->databaseConnector->update(
                table: "users",
                data: ["email" => $this->databaseConnector->escape($newEmail)],
                conditionColumn: "uuid",
                conditionValue: $currentUser["uuid"]
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }

    /**
     * Change the password of the current user
     * @param string $newPassword
     * @return void
     * @throws Exception
     */
    public function changePassword(string $newPassword): void
    {
        try {
            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro změnu hesla se musíte přihlásit.");
            }

            $this->databaseConnector->update(
                table: "users",
                data: ["password" => $this->utilityService->hash($newPassword)],
                conditionColumn: "uuid",
                conditionValue: $currentUser["uuid"]
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }

    /**
     * Change the name (label) of the current user
     * @param string $newName
     * @return void
     * @throws Exception
     */
    public function changeName(string $newName): void
    {
        try {
            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro změnu hesla se musíte přihlásit.");
            }

            $this->databaseConnector->update(
                table: "users",
                data: ["label" => $this->databaseConnector->escape($newName)],
                conditionColumn: "uuid",
                conditionValue: $currentUser["uuid"]
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }


    /**
     * Change the settings like avatar, banner and bio
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
            "pic_profile" => $this->databaseConnector->escape(
                $this->utilityService->normalizeString($newSettings["avatar"])
            ),
            "pic_banner" => $this->databaseConnector->escape(
                $this->utilityService->normalizeString($newSettings["banner"])
            ),
            "bio" => $this->databaseConnector->escape($this->utilityService->normalizeString($newSettings["bio"])),
        ];

        $settings = $this->getUserSettings($currentUser["uuid"]);
        try {
            if (empty($settings)) {
                $this->databaseConnector->insert(
                    table: "users_settings",
                    data: $result
                );
            } else {
                $this->databaseConnector->update(
                    table: "users_settings",
                    data: $result,
                    conditionColumn: "user",
                    conditionValue: $currentUser["uuid"]
                );
            }
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }

    /**
     * Add a new drone
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function droneAdd(array $data): void
    {
        if (empty($data["drone_name"]) || empty($data["drone_description"])) {
            return;
        }

        try {
            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro přidání dronu musíte být přihlášený");
            }

            // normalize drone params
            foreach ($data["params"] as $key => $value) {
                $data["params"][$key] = $this->databaseConnector->escape($value);
            }

            $result = [
                "owner" => $currentUser["uuid"],
                "drone_name" => $this->databaseConnector->escape($data["drone_name"]),
                "drone_description" => $this->databaseConnector->escape($data["drone_description"]),
                "drone_params" => json_encode($data["params"]),
                "drone_img" => $this->databaseConnector->escape($data["drone_img"]),
            ];

            $this->databaseConnector->insert(
                table: "users_drones",
                data: $result
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }

    /**
     * Edit an existing drone
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function droneEdit(array $data): void
    {
        if (empty($data["drone_name"]) || empty($data["drone_description"]) || empty($data["drone_id"])) {
            return;
        }

        try {
            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro aktualizaci dronu musíte být přihlášený");
            }

            $currentDroneData = $this->databaseConnector->selectOneRow("
                SELECT * FROM users_drones
                WHERE id = '" . $this->databaseConnector->escape($data["drone_id"]) . "'"
            );
            if (empty($currentDroneData)) {
                throw new Exception("Dron nebyl nalezen");
            }

            if ($currentDroneData["owner"] != $currentUser["uuid"]) {
                throw new Exception("Nemáte oprávnění k úpravě tohoto dronu");
            }

            // normalize drone params
            foreach ($data["params"] as $key => $value) {
                $data["params"][$key] = $this->databaseConnector->escape($value);
            }

            $result = [
                "drone_name" => $this->databaseConnector->escape($data["drone_name"]),
                "drone_description" => $this->databaseConnector->escape($data["drone_description"]),
                "drone_params" => json_encode($data["params"]),
                "drone_img" => $this->databaseConnector->escape($data["drone_img"]),
            ];

            $this->databaseConnector->update(
                table: "users_drones",
                data: $result,
                conditionColumn: "id",
                conditionValue: $data["drone_id"],
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }

    /**
     * Delete an existing drone
     * @param int $droneId
     * @return void
     * @throws Exception
     */
    public function droneDelete(int $droneId): void
    {
        try {
            $currentUser = $this->authController->getCurrentUser() ?? [];
            if (empty($currentUser)) {
                throw new Exception("Pro smazání dronu musíte být přihlášený");
            }

            $currentDroneData = $this->databaseConnector->selectOneRow(
                "
                SELECT * FROM users_drones
                WHERE id = '" . $this->databaseConnector->escape($droneId) . "'"
            );
            if (empty($currentDroneData)) {
                throw new Exception("Dron nebyl nalezen");
            }

            if ($currentDroneData["owner"] != $currentUser["uuid"]) {
                throw new Exception("Nemáte oprávnění k úpravě tohoto dronu");
            }

            $this->databaseConnector->delete(
                table: "users_drones",
                conditionColumn: "id",
                conditionValue: $droneId
            );
        } catch (Exception $e) {
            header("Location: /error?error=" . $e->getMessage()); exit();
        }
    }
}