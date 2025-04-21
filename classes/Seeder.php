<?php
class Seeder extends ControllerV2
{
    /**
     * Populate missing unique IDs for a given table column.
     *
     * @param string $table         The name of the table.
     * @param string $idColumn      The column used to uniquely identify each row (e.g., "id").
     * @param string $targetColumn  The column where the unique ID should be inserted (e.g., "product_id").
     * @param int    $length        Optional: Length of the ID (ignored if $useHyphens is true).
     * @param bool   $useHyphens    Optional: Generate UUID-style ID with hyphens (overrides length).
     */
    public function populateUniqueIDs(string $table, string $idColumn = 'id', string $targetColumn = 'product_id', bool $useHyphens = false)
    {
        $records = $this->fetchResult($table); // Fetch all records

        while ($row = mysqli_fetch_assoc($records)) {
            $recordId = $row[$idColumn];

            // Skip if ID already exists
            if (!empty($row[$targetColumn])) {
                continue;
            }

            $generatedId = UniqueID::generate($table, $targetColumn, $useHyphens);

            $this->updates(
                $table,
                U::col("$targetColumn = '$generatedId'"),
                U::where("$idColumn = $recordId")
            );
        }

        echo "✅ '$targetColumn' generated for all applicable records in '$table'!";
    }
}
// (new Seeder)->populateUniqueIDs("product", "id", "product_id", true);

