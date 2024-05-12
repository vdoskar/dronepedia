<?php

class DatabaseConnector
{
    private mysqli $connection;
    private string $servername = "localhost";
    private string $db = "dronepedia";
    private string $username = "root";
    private string $password = "";

    public function __construct()
    {
        $this->connection = new mysqli(
            hostname: $this->servername,
            username: $this->username,
            password: $this->password,
            database: $this->db
        );

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * Insert the data into the given table
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
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Delete the data from the given table based on the condition
     * @param string $table
     * @param string $conditionColumn
     * @param string|int|float $conditionValue
     * @return void
     * @throws Exception
     */
    public function delete(string $table, string $conditionColumn, string|int|float $conditionValue): void
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
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the data in the given table based on the condition
     * @param string $table
     * @param array $data
     * @param string $conditionColumn
     * @param string|int|float|null $conditionValue
     * @return void
     * @throws Exception
     */
    public function update(
        string $table,
        array $data,
        string $conditionColumn = "",
        string|int|float|null $conditionValue = null
    ): void {
        $this->connection->begin_transaction();
        try {
            $sql = "UPDATE " . $table . " SET ";

            foreach ($data as $column => $value) {
                $sql .= "$column = ?, ";
            }
            $sql = rtrim($sql, ', ');

            if (!empty($conditionColumn)) {
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
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Query that returns a single row as an associative array
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
     * Query that returns a single value (e.g. MAX, COUNT, etc.)
     * @param string $query
     * @return mixed
     */
    public function selectOneValue(string $query): mixed
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
     * Query that returns multiple rows as an associative array
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

    /**
     * Escape the string to prevent SQL injection
     * @param string $string
     * @return string
     */
    public function escape(string $string): string
    {
        return htmlspecialchars($this->connection->real_escape_string($string));
    }
}