<?php

require_once 'src/services/AdminService.php';

final class AdminPostsService extends AdminService
{
    /**
     * Saves all posts data at once
     * @param array $postData
     * @return void
     * @throws Exception
     */
    public function saveAll(array $postData): void
    {
        try {
            foreach ($postData as $slug => $post) {
                $data = [
                    "title" => $post["title"],
                    "short_summary" => $post["short_summary"],
                    "category" => $post["category"],
                    "status" => $post["status"],
                ];

                $this->databaseConnector->update(
                    table: "posts",
                    data: $data,
                    conditionColumn: "slug",
                    conditionValue: $slug);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}