<?php
class UniqueID extends ControllerV2
{
    /**
     * Generate a UUID v4-compliant unique ID.
     * 
     * @param string $table   Table name
     * @param string $column  Column name to ensure uniqueness
     * @param bool $useHyphens Format with hyphens (UUID style)
     * @return string
     */
    public static function generate(string $table, string $column, bool $useHyphens = true): string
    {
        $self = new static();

        do {
            $data = random_bytes(16);

            // Set version to 4 (UUIDv4)
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
            // Set variant to 10xxxxxx
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

            $raw = bin2hex($data);

            if ($useHyphens) {
                $id = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($raw, 4));
            } else {
                $id = $raw;
            }

            $exists = $self->fetchResult($table, where: ["$column = $id"]);
        } while (mysqli_num_rows($exists) > 0);

        return $id;
    }
}
