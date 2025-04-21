<?php
class U
{
    public static function col(...$cols)
    {
        $result = [];
        foreach ($cols as $value) {
            list($key, $val) = explode('=', $value, 2);
            $key = trim($key);
            $val = trim($val);

            // Treat as SQL expression if math operators are present
            if (preg_match('/[a-zA-Z_]+\s*[\+\-\*\/]/', $val) || strtoupper($val) === 'NOW()') {
                $result[$key] = ['expression' => $val];
            } elseif (preg_match('/^\$[a-zA-Z0-9_]+$/', $val)) {
                // Still allow \$var syntax
                $result[$key] = $val;
            } elseif (isset($GLOBALS[$val])) {
                // Automatically bind if variable exists in global scope
                $result[$key] = $GLOBALS[$val];
            } elseif (isset($GLOBALS[trim($val, "'")])) {
                // fallback for quoted strings like 'Cash/Transfer'
                $result[$key] = $GLOBALS[trim($val, "'")];
            } else {
                // Bind literal
                $result[$key] = $val;
            }
        }
        return $result;
    }


    public static function where(...$where)
    {
        $result = [];
        foreach ($where as $value) {
            list($key, $val) = explode('=', $value, 2);
            $key = trim($key);
            $val = trim($val);

            if (preg_match('/^\$[a-zA-Z0-9_]+$/', $val)) {
                $result[$key] = $val;
            } elseif (isset($GLOBALS[$val])) {
                $result[$key] = $GLOBALS[$val];
            } elseif (isset($GLOBALS[trim($val, "'")])) {
                $result[$key] = $GLOBALS[trim($val, "'")];
            } else {
                $result[$key] = $val;
            }
        }
        return $result;
    }
}
