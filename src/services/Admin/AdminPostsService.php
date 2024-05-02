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
        $data = [
            "status" => "CLOSED",
        ];

        $this->databaseConnector->update(
            "posts",
            $data,
            "slug",
            $slug,
        );
    }

    /**
     * @param string $slug
     * @return void
     * @throws Exception
     */
    public function open(string $slug): void
    {
        $data = [
            "status" => "ACTIVE",
        ];

        $this->databaseConnector->update(
            "posts",
            $data,
            "slug",
            $slug,
        );
    }

    /**
     * @param string $slug
     * @return void
     * @throws Exception
     */
    public function delete(string $slug): void
    {
        $this->postsController->delete($slug);
    }
}