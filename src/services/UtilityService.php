<?php

class UtilityService
{
    public function __construct()
    {

    }

    /**
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

    public function hash(string $data): string
    {
        return hash("sha256", $data);
    }
}