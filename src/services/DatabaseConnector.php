<?php

// use Exception;
// use mysqli;

class DatabaseConnector
{
    private mysqli $connection;

    private string $servername = "127.0.0.1";
    private string $db = "tulwa";
    private string $username_admin = "root";
    private string $password_admin = "";
    private string $username_user = "root";
    private string $password_user = "";

    public function __construct()
    {
         $this->connection = new mysqli(
             $this->servername,
             $this->username_admin,
             $this->password_admin,
             $this->db
         );

         if ($this->connection->connect_error) {
             die("Connection failed: " . $this->connection->connect_error);
         }
    }

    /**
     * @param string $table
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function insert(string $table, array $data): void
    {
        $this->connection->begin_transaction();
        try {
            $sql = "INSERT INTO " . $table . "(";

            $sql .= implode(', ', array_keys($data));

            $sql .= ") VALUES (";
            $sql .= str_repeat('?, ', count($data) - 1) . '?)';

            $stmt = $this->connection->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $this->connection->error);
            }

            $types = str_repeat('s', count($data));
            $stmt->bind_param($types, ...array_values($data));

            if (!$stmt->execute()) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    /**
     * @param string $table
     * @param string $conditionColumn
     * @param $conditionValue
     * @return void
     * @throws Exception
     */
    public function delete(string $table, string $conditionColumn, $conditionValue): void
    {
        $this->connection->begin_transaction();
        try {

            $sql = "DELETE FROM " . $table . " WHERE $conditionColumn = ?";

            $stmt = $this->connection->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $this->connection->error);
            }

            $stmt->bind_param('s', $conditionValue);
            if (!$stmt->execute()) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    /**
     * @param string $table
     * @param array $data
     * @param string|null $conditionColumn
     * @param $conditionValue
     * @return void
     * @throws Exception
     */
    public function update(
        string $table,
        array $data,
        string|null $conditionColumn = null,
        $conditionValue = null
    ): void {
        $this->connection->begin_transaction();
        try {
            $sql = "UPDATE " . $table . " SET ";

            foreach ($data as $column => $value) {
                $sql .= "$column = ?, ";
            }
            $sql = rtrim($sql, ', ');

            if ($conditionColumn) {
                $sql .= " WHERE $conditionColumn = ?";
            }

            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $this->connection->error);
            }

            $types = str_repeat('s', count($data));
            $types .= 's';

            $values = array_merge(array_values($data), [$conditionValue]);

            $stmt->bind_param($types, ...$values);
            if (!$stmt->execute()) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    /**
     * @param string $query
     * @return array|null
     * @throws Exception
     */
    public function selectOneRow(string $query): ?array
    {
        $result = $this->connection->query($query);
        if (!$result || $result->num_rows === 0) {
            return null;
        }

        $row = $result->fetch_assoc();
        $result->free();

        return $row;
    }

    /**
     * @param string $query
     * @return string|int|float|null
     */
    public function selectOneValue(string $query): string|int|float|null
    {
        $result = $this->connection->query($query);
        if (!$result || $result->num_rows === 0) {
            return null;
        }

        $row = $result->fetch_array(MYSQLI_NUM);
        $value = $row[0];
        $result->free();

        return $value;
    }

    /**
     * @param string $query
     * @return array
     */
    public function selectAll(string $query): array
    {
        $result = $this->connection->query($query);
        if (!$result || $result->num_rows === 0) {
            return [];
        }

        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();

        return $rows;
    }

    public function escape(string $string): string
    {
        // remove potentioal harmful characters from cross site scripting
        return htmlspecialchars($this->connection->real_escape_string($string));
    }
}