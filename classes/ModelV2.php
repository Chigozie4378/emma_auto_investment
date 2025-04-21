<?php
class ModelV2 extends DB
{

    protected $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect(); // shared connection
    }

    function __destruct()
    {
        if (method_exists($this, 'closeConnection')) {
            $this->closeConnection();
        }
    }
    protected function insertData($table_name, $data_array)
    {


        // Build query string
        $query = "INSERT INTO $table_name VALUES (";
        $query .= str_repeat('?,', count($data_array[0]));
        $query = rtrim($query, ',');
        $query .= ")";

        // Prepare the statement
        $stmt = $this->dbconn->prepare($query);

        // Bind parameters
        $types = '';
        foreach ($data_array[0] as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_double($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        $stmt->bind_param($types, ...array_values($data_array[0]));

        // Execute the statement for each set of data
        foreach ($data_array as $data) {
            $stmt->execute();
            if ($stmt->error) {
                die("Error: " . $stmt->error . $data);
            }
        }

        // Close statement and connection
        $stmt->close();
    }

    protected function selectQuery(
        $table_name,
        $where_conditions = [],
        $operators = [],
        $logicals = [],
        $cols = "*",
        $distinct = null,
        $additional = null,
        $order_by = null,
        $group_by = null,
        $having = null,
        $limit = null,
        $join = [],
        $offset = null
    ) {

        $queryParts = [];

        $selectClause = "SELECT " . ($distinct ? "DISTINCT $distinct" : $cols);
        $queryParts[] = "$selectClause FROM $table_name";

        // JOIN
        if (!empty($join)) {
            foreach ($join as $table => $condition) {
                if ($table === "type") continue;
                $joinType = strtoupper($join["type"] ?? "INNER");
                $queryParts[] = "$joinType JOIN $table ON $condition";
            }
        }

        // WHERE + HAVING
        list($whereClause, $whereParams, $havingData) = $this->formatWhereConditions($where_conditions, $operators, $logicals);
        $havingClause = $havingData[0] ?? '';
        $havingParams = $havingData[1] ?? [];

        if (!empty($whereClause)) {
            $queryParts[] = "WHERE $whereClause";
        }
        if (!empty($group_by)) {
            $queryParts[] = "GROUP BY $group_by";
        }
        if (!empty($havingClause)) {
            $queryParts[] = "HAVING $havingClause";
        }
        if (!empty($having)) {
            $queryParts[] = "HAVING $having";
        }
        if (!empty($order_by)) {
            $queryParts[] = "ORDER BY $order_by";
        }
        if (!empty($limit)) {
            $queryParts[] = "LIMIT ?";
        }
        if (!empty($offset)) {
            $queryParts[] = "OFFSET ?";
        }

        $query = implode(" ", $queryParts);


        $stmt = $this->dbconn->prepare($query);

        if (!$stmt) {
            throw new Exception("Database error: " . $this->dbconn->error);
        }

        $bindValues = array_merge($whereParams, $havingParams);
        if (!empty($limit)) {
            $bindValues[] = (int)$limit;
        }
        if (!empty($offset)) {
            $bindValues[] = (int)$offset;
        }

        if (!empty($bindValues)) {
            $types = '';
            foreach ($bindValues as $val) {
                $types .= is_int($val) ? 'i' : 's';
            }
            $stmt->bind_param($types, ...$bindValues);
        }
        // // Debugging output
        // echo "<pre>";
        // echo "SQL Query:\n$query\n";
        // echo "Bind Values:\n";
        // print_r($bindValues);
        // echo "</pre>";

        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }


    /**
     * Formats WHERE conditions properly
     */
    public function formatWhereConditions($where_conditions, $comparison_operators = [], $logical_operators = [])
    {
        if (empty($where_conditions))
            return ["", [], []];

        $formatted_conditions = [];
        $where_params = [];
        $having_conditions = [];
        $having_params = [];

        $index = 0;

        $valid_index = 0; // Track only valid conditions

        foreach ($where_conditions as $condition) {
            $operator = isset($comparison_operators[$index]) ? strtoupper($comparison_operators[$index]) : "=";

            // Skip invalid or malformed conditions
            if (!preg_match('/^(.+?)=(.*)$/', $condition, $matches)) {
                $index++;
                continue;
            }

            $column = trim($matches[1]);
            $value = trim($matches[2]);

            // Skip conditions with empty value
            if ($value === "") {
                $index++;
                continue;
            }

            $condition_str = "";
            $param_values = [];

            // IN with raw subquery (e.g., id=SELECT ... GROUP BY ...)
            if ($operator === "IN" && preg_match('/^SELECT\b/i', $value)) {
                $condition_str = "$column IN ($value)";
                $param_values = [];
            }
            // IN with array
            elseif ($operator === "IN" && preg_match('/\[(.+?)\]/', $value, $arrMatches)) {
                $values = explode(",", $arrMatches[1]);
                $placeholders = implode(",", array_fill(0, count($values), "?"));
                $condition_str = "$column IN ($placeholders)";
                $param_values = array_map('trim', $values);
            }

            // BETWEEN
            elseif ($operator === "BETWEEN" && preg_match('/\[(.+?),(.+?)\]/', $value, $arrMatches)) {
                $val1 = trim($arrMatches[1]);
                $val2 = trim($arrMatches[2]);
                $condition_str = "$column BETWEEN ? AND ?";
                $param_values = [$val1, $val2];
            }
            // LIKE
            elseif ($operator === "LIKE") {
                $condition_str = "$column LIKE ?";
                $param_values = ["%$value%"];
            }
            // SQL functions
            elseif (preg_match('/\b(NOW\(\)|INTERVAL|DATE|CURRENT_DATE|CURRENT_TIMESTAMP)\b/i', $value)) {
                $condition_str = "$column $operator $value";
                $param_values = [];
            }
            // Default
            else {
                $condition_str = "$column $operator ?";
                $param_values = [$value];
            }

            // Logical operator — only prefix if not the first valid condition
            $logical_operator = $valid_index > 0 ? "AND " : "";
            $final_condition = $logical_operator . "($condition_str)";

            if (preg_match('/SUM|COUNT|AVG|MIN|MAX/i', $column)) {
                $having_conditions[] = $final_condition;
                $having_params = array_merge($having_params, $param_values);
            } else {
                $formatted_conditions[] = $final_condition;
                $where_params = array_merge($where_params, $param_values);
            }

            $valid_index++;
            $index++;
        }



        return [implode(" ", $formatted_conditions), $where_params, [implode(" ", $having_conditions), $having_params]];
    }


    protected function deleteWhere($table_name, $where_array)
    {


        // Build query string
        $query = "DELETE FROM $table_name WHERE ";
        $where_clause = array();
        foreach ($where_array as $key => $value) {
            $where_clause[] = "$key = ?";
        }
        $query .= implode(" AND ", $where_clause);

        // Prepare the statement
        $stmt = $this->dbconn->prepare($query);

        // Bind parameters
        $types = "";
        foreach ($where_array as $value) {
            if (is_int($value)) {
                $types .= "i";
            } elseif (is_double($value)) {
                $types .= "d";
            } else {
                $types .= "s";
            }
        }
        $stmt->bind_param($types, ...array_values($where_array));

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Close statement and connection
        $stmt->close();


        // Return the result object
        return $result;
    }

    protected function updateData($table, $update_columns, $where_columns)
    {

        $sql = "UPDATE $table SET ";
        $update_values = [];

        // Build SET part
        foreach ($update_columns as $column_name => $new_value) {
            if (is_array($new_value) && isset($new_value['expression'])) {
                // Inline SQL expression
                $sql .= "$column_name = {$new_value['expression']}, ";
            } elseif (preg_match('/^\$[a-zA-Z0-9_]+$/', $new_value)) {
                // Dynamic variable bind
                $sql .= "$column_name = ?, ";
                $varName = substr($new_value, 1);
                global $$varName;
                $update_values[] = $$varName;
            } else {
                // Bind literal values
                $sql .= "$column_name = ?, ";
                $update_values[] = $new_value;
            }
        }
        $sql = rtrim($sql, ', ');

        // Build WHERE part
        if (!empty($where_columns)) {
            $sql .= " WHERE ";
            foreach ($where_columns as $column_name => $condition_value) {
                if (preg_match('/^\$[a-zA-Z0-9_]+$/', $condition_value)) {
                    // Dynamic variable
                    $sql .= "$column_name = ? AND ";
                    $varName = substr($condition_value, 1);
                    global $$varName;
                    $update_values[] = $$varName;
                } else {
                    // Treat other values as bind parameters as well
                    $sql .= "$column_name = ? AND ";
                    $update_values[] = $condition_value;
                }
            }
            $sql = rtrim($sql, 'AND ');
        }


        // Uncomment to execute for real
        $stmt = $this->dbconn->prepare($sql);
        if (!empty($update_values)) {
            $types = '';
            foreach ($update_values as $value) {
                $types .= is_numeric($value) ? 'd' : 's';
            }
            // // 🔍 Debug output
            // echo "<pre>";
            // echo "SQL: " . $sql . "\n";
            // echo "Bind types: " . $types . "\n";
            // echo "Bind values:\n";
            // print_r($update_values);
            // echo "</pre>";
            $stmt->bind_param($types, ...array_values($update_values));
        }


        $stmt->execute();
        $stmt->close();
    }



    protected function invoiceLock()
    {

        $stmt = $this->dbconn->prepare("SELECT * FROM sales FOR UPDATE");
        $stmt->execute();
        $stmt->close();
    }
    protected function invoiceUnlock()
    {

        $stmt = $this->dbconn->prepare("UNLOCK TABLES");
        $stmt->execute();
        $stmt->close();
    }




    protected function deleteWhereAndJoin($table1, $table2, $column, ...$where_clauses)
    {


        // Construct the subquery

        $subquery = "SELECT * FROM $table1
        JOIN $table2 ON $table1.$column = $table2.$column";

        if (!empty($where_clauses)) {
            $subquery .= " WHERE ";
            $subquery .= implode(" AND ", $where_clauses);
        }

        // Prepare DELETE query using a prepared statement
        $query = "DELETE FROM $table1 WHERE $column IN ($subquery)";
        $stmt = $this->dbconn->prepare($query);

        if ($stmt) {
            // Execute the prepared statement
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Query preparation failed: " . $this->dbconn->error;
        }
    }
}
