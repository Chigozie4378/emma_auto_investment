<?php
class ControllerV2 extends ModelV2
{
  public function __construct()
    {
      parent::__construct(); 
    }
  protected function insert($table_name, ...$values)
  {
    $data_array = array();

    // Add null as the first value
    $data_array[] = null;

    // Add the remaining values to the data array
    foreach ($values as $value) {
      $data_array[] = $value;
    }

    // Insert the data into the table
    $this->insertData($table_name, array($data_array));
  }
  public function fetchResult(
    $table_name,
    $where = [],
    $oper = [],
    $log = [],
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
    // Legacy fallback still supported:
    $allParams = [&$where, &$oper, &$log, &$cols, &$distinct, &$additional, &$order_by, &$group_by, &$having, &$limit, &$join];
    foreach ($allParams as &$param) {
      if (is_array($param) && $this->isLegacyOptionArray($param)) {
        foreach ($param as $key => $value) {
          switch ($key) {
            case 'where':
              $where = $value;
              break;
            case 'oper':
              $oper = $value;
              break;
            case 'log':
              $log = $value;
              break;
            case 'cols':
              $cols = $value;
              break;
            case 'distinct':
              $distinct = $value;
              break;
            case 'additional':
              $additional = $value;
              break;
            case 'order_by':
              $order_by = $value;
              break;
            case 'group_by':
              $group_by = $value;
              break;
            case 'having':
              $having = $value;
              break;
            case 'limit':
              $limit = $value;
              break;

            case 'join':
              $join = $value;
              break;
            case 'offset':
              $offset = $value;
              break;
            
          }
        }
        $param = [];
      }
    }

    return $this->selectQuery(
      $table_name,
      $where,
      $oper,
      $log,
      $cols,
      $distinct,
      $additional,
      $order_by,
      $group_by,
      $having,
      $limit,
      $join,
      $offset
    );
  }


  private function isLegacyOptionArray(array $arr): bool
  {
    $keys = array_keys($arr);
    $knownKeys = [
      'where',
      'oper',
      'log',
      'cols',
      'distinct',
      'additional',
      'order_by',
      'group_by',
      'having',
      'limit',
      'join'
    ];
    return count(array_intersect($keys, $knownKeys)) > 0;
  }



  protected function trashWhere($table_name, ...$where_clauses)
  {
      $where_array = array();
      foreach ($where_clauses as $where_clause) {
          $parts = explode('=', $where_clause, 2);
          $key = trim($parts[0]);
          $value = trim($parts[1], " '"); // Trim spaces and quotes
          $where_array[$key] = $value;
      }
  
      return $this->deleteWhere($table_name, $where_array);
  }
  


  protected function updates($table, $update_columns, $where_columns)
  {
    $this->updateData($table, $update_columns, $where_columns);
  }




  protected function lockInvoice()
  {
    $this->invoiceLock();
  }
  //   protected function unlockInvoice()
  //   {
  //     $this->invoiceUnlock();
  //   }

  //   protected function getPaginated($table_name, $offset, $records_per_page)
  //   {
  //     return $this->selectPagination($table_name, $offset, $records_per_page);
  //   }

  //   protected function trashWhereLikeAndJoin($table1, $table2, $column, ...$where_clauses)
  //   {
  //     return $this->deleteWhereAndJoin($table1, $table2, $column, ...$where_clauses);
  //   }
}
