<?php

class AdminUserService extends AdminService
{
    /**
     * Saves all users data at once
     * @param array $userData
     * @return void
     * @throws Exception
     */
    public function saveAll(array $userData): void
    {
        try {
           foreach ($userData as $userUuid => $user) {
                $data = [
                    "label" => $user["label"],
                    "username" => $user["username"],
                    "email" => $user["email"],
                    "role" => $user["role"],
                    "failed_login_attempts" => $user["failed_login_attempts"],
                ];

                $this->databaseConnector->update(
                    table: "users",
                    data: $data,
                    conditionColumn: "uuid",
                    conditionValue: $userUuid,
                );
           }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}