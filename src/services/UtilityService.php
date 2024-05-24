<?php

class UtilityService
{
    public function __construct()
    {
    }

    /**
     * Generate a random UUID v4
     * @return string
     * @throws Exception
     */
    public function uuidV4(): string
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Hash the data using sha256
     * @param string $data
     * @return string
     */
    public function hash(string $data): string
    {
        return hash("sha256", $data);
    }

    /**
     * Remove multiple spaces, tabs, new lines and trim the string
     * @param string $data
     * @return string
     */
    public function normalizeString(string $data): string
    {
        return trim(preg_replace('/\s+/', ' ', $data));
    }

    /**
     * Compare two values
     * @param string|int|float $value1
     * @param string|int|float $value2
     * @return bool
     */
    public function areValuesEqual(string|int|float $value1, string|int|float $value2): bool
    {
        return $value1 === $value2;
    }
}