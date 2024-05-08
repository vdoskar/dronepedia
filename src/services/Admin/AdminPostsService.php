<?php

class AdminPostsService extends AdminService
{
    /**
     * @param string $slug
     * @return void
     * @throws Exception
     */
    public function close(string $slug): void
    {
        try {
            $data = [
                "status" => "CLOSED",
            ];

            $this->databaseConnector->update(
                "posts",
                $data,
                "slug",
                $slug,
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $slug
     * @return void
     * @throws Exception
     */
    public function open(string $slug): void
    {
        try {
            $data = [
                "status" => "ACTIVE",
            ];

            $this->databaseConnector->update(
                "posts",
                $data,
                "slug",
                $slug,
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $slug
     * @return void
     * @throws Exception
     */
    public function delete(string $slug): void
    {
        try {
            $this->postsController->delete($slug);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}