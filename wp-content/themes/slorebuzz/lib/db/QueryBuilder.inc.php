<?php
/**
 * Query builder class.
 *
 * Provides helpful functions to create PDO queries.
 *
 * @package DB
 */
class QueryBuilder {

   /**
    * Creats an INSERT query with parameterized input values.
    * Returns an SQL INSERT statement and the parameters in a 2 element array.
    *
    * Assumes the primary key is in $values and does not already exist.
    *
    * Uses the DESCRIBE statement so that items in the $values array are
    * only included in the INSERT if a matching column name exists
    * from DESCRIBE. (This is a case-sensitive compare.)
    *
    * @param string $tblName
    *   Name of the table to update.
    * @param array $values
    *   Associative array containing the column names & values to insert.
    *   Name/value pairs that don't belong in the database will not be
    *   included in the INSERT statement.
    *
    * @return array
    *   First element is the SQL string describing the INPUT command to process.
    *   Second element in another array of the parameters to use in the query.
    */
   public static function CreateInsert(&$conn, $tblName, $values,
                                        $colNames = null) {
      $insNames = array_keys($values);
      $insVals  = array_values($values);

      $numCols = count($insNames);
      $names = $vals = $params = '';

      if ($colNames === null)
         $colNames = QueryBuilder::ColNamesForTable($conn, $tblName);

      for ($ndx = 0; $ndx < $numCols; $ndx++) {
         $curColName = $insNames[$ndx];

         if (!in_array($curColName, $colNames))
            continue;

         // build column names and parameter holders
         $names[]  = "`$curColName`";
         $params[] = '?';

         // empty values are converted to null for DB inserts
         if (trim($insVals[$ndx]) == '')
            $vals[] = null;
         else
            $vals[]   = $insVals[$ndx];
      }

      // add commas
      $names = implode(', ', $names);
      $params = implode(', ', $params);

      $qry = "INSERT INTO $tblName\n ($names)\n VALUES (\n   $params)";

      return array($qry, $vals);
   }

   /**
    * Get an array of the column names for a given table.
    *
    * Useful if doing multiple inserts to the same table and you don't
    * want the CreateInsert() function calling this every time.
    *
    * Assumes we're using MySQL and have access to the 'DESCRIBE' statement.
    *
    * @param object
    *   DBO connection object.
    * @param string
    *   Name of the table you'd like to find column names for.
    * @return array
    *   Array of names of the columns in the table.
    */
   public static function ColNamesForTable(&$conn, $tblName) {
      $qry = "DESCRIBE $tblName";
      $stmt = $conn->query($qry);

      // column 0 is 'Field', the name of the row Field
      return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
   }

   /**
    * Creates an SQL statement for updating a table.
    *
    * Returns an empty string if no update is necessary.
    *
    * @param string $tableName - Name of the table to update
    * @param array $newData    - Associative array of data to update in this
    *  table.  Should contain col_name/value pairs.
    * @param string|array $id  - Primary key value(s) for which this update
    *  applies. This is not the name(s) of the primary keys.
    *  May be an array or a single value. If an array, the values must
    *  be in the same order the primary key columns appear in in the
    *  database.
    *
    * @return string|array The query to execute to do the update. Will be
    *  an empty string if no update is necessary ($newData doesn't change
    *  any of the existing data), a string with question marks holding the
    *  place of the $id, or an array of two values: the first value is the
    *  (parameterized) query to execute, the second is the array of
    *  parameters.
    *
    * Assumes:
    *  We are connected to a mySQL database.
    *  Result sets are set to ADODB_FETCH_ASSOC.
   */
   public static function CreateUpdate($conn, $tableName, $newData, $id) {
      if (!is_array($id))
         $id = array($id);

      $keys    = self::PKColumnsForTable($conn, $tableName);
      $oldData = self::FetchExistingRow($conn, $tableName, $keys, $id);
      $updates = array();

      // compile the UPDATE w/ only the parameters that have changed
      foreach ($oldData as $col => $val) {
         if (array_key_exists($col, $newData)
               && $newData[$col] != $val
               && !in_array($col, $keys)) {

            $updates[] = "$col = ?";

            if (trim($newData[$col]) == '')
               $dataParams[] = null;
            else
               $dataParams[] = $newData[$col];
         }
      }

      if (!empty($updates)) {
         $data = implode(",\n  ", $updates);
         $qry  = "UPDATE `$tableName`\n SET $data\n " .
                 self::_pkWhereClause($keys);

         return array($qry, array_merge($dataParams, $id));
      }
      else
         return '';
   }

   /**
    * Get an array list of the column names that are part of the primary key
    * for a given table.
    *
    * @param object   PDO DB connection object.
    * @param string   Name of the table you'd like to find out the PKs for.
    * @return array   Array list of the names of the column that make up the PK.
    */
   public static function PKColumnsForTable(&$conn, $tableName) {
      $sTableName = '`' . $tableName . '`';

      // get the table description
      $qry = "DESCRIBE $sTableName";
      $res = $conn->query($qry);

      // find the name of the primary key column
      foreach ($res as $curRow) {
         if ($curRow['Key'] == 'PRI') {
            $keys[] = $curRow['Field'];
         }
      }

      return $keys;
   }

   /**
    * Look up an existing row from the database using its PK for the search.
    *
    * @param object   PDO DB connection object.
    * @param string   Name of the table we're querying.
    * @param array    List of the names of the primary keys of the table.
    * @param array    Values for each of the primary keys in the table. Must
    *                 have the same number of elements as $keys.
    *
    * @return array   Associative array of a row from the table.
    */
   public static function FetchExistingRow(&$conn, $tableName, $keys, $id) {
      // get the existing data to compare $newData to
      $qry = "SELECT *
              FROM `$tableName`";

      $qry .= self::_pkWhereClause($keys);

      $stmt = $conn->prepare($qry);
      $stmt->execute($id);
      return $stmt->fetch();
   }

   /**
    * Create the where clause that specifies the primary key.
    *
    * @param array    List of the names of the primary keys of the table.
    * @return string  SQL WHERE clause, parameterized with ?'s
    */
   protected static function _pkWhereClause($keys) {
      if (empty($keys))
         die('cannot create WHERE clause when no PKs specified');

      for ($ndx = 0; $ndx < count($keys); $ndx++) {
         if ($ndx == 0)
            $where = " WHERE {$keys[$ndx]} = ?";
         else
            $where .= "\n   AND {$keys[$ndx]} = ?";
      }

      return $where;
   }

   /*
    Go through all the fieldNames and compare oldData vs. newData
    Each field name is appended with $nameMod.

    If a value exists in new data && doesn't exist in the old data, insert
    If a value exists in old data && doesn't exist in the new data, delete
    If a value in new data is than the one in old data, update
   */
   private function GetUpdates($fieldNames, $newData, $oldData, $nameMod = '') {
      if (!is_array($fieldNames))
         die("Error w/ value: $fieldNames - is not an array");

      $updates = array();

      foreach ($fieldNames as $curField) {
         $curField .= $nameMod;
         $oldValue  = null;

         foreach ($oldData as $row) {
            if ($row[$this->linkColMeta[1]] == $curField) {
               $oldValue = $row[$this->linkColMeta[2]];

               if (is_null($oldValue))
                  $oldValue = '';

               break;
            }
         }

         if (array_key_exists($curField, $newData) && $oldValue === null ) {

            if ($newData[$curField] != '')
               $updates[] = $this->CreateSQL('INSERT',
                $curField, $newData[$curField]);
         }
         else if (!array_key_exists($curField, $newData) && $oldValue != null ){
            $updates[] = $this->CreateSQL('DELETE',
             $curField, $oldValue);
         }
         else if (array_key_exists($curField, $newData)
                  && $newData[$curField] != $oldValue) { // update
            $updates[] = $this->CreateSQL('UPDATE',
             $curField, $newData[$curField]);
         }
      }

      return $updates;
   }

   /*
    Used by $this->GetUpdates(...)
   */
   private function CreateSQL($type, $name, $value) {
      $stmt = '';
      $sName = $this->sFromUns($name);
      $sValue = $this->sFromUns($value);

      $linkCol = $this->linkColMeta[0];
      $nameCol = $this->linkColMeta[1];
      $valCol  = $this->linkColMeta[2];

      if ($type == 'INSERT') {
         $stmt = "INSERT INTO {$this->tableName}
                  ($linkCol, $nameCol, $valCol)
                  VALUES ({$this->linkID}, $sName, $sValue)";
      }
      else if ($type == 'DELETE') {
         $stmt = "DELETE FROM {$this->tableName}
                  WHERE $linkCol = {$this->linkID}
                  AND $nameCol = $sName
                  AND $valCol  = $sValue";
      }
      else if ($type == 'UPDATE') {
         $stmt = "UPDATE {$this->tableName}
                  SET $valCol = $sValue
                  WHERE $linkCol = {$this->linkID}
                   AND $nameCol = $sName";
      }

      return $stmt;
   }
}

class MySQLQueryBuilder extends QueryBuilder {

   /**
    * Creats an INSERT query with parameterized input values.
    * Returns an SQL INSERT statement and the parameters in a 2 element array.
    *
    * Assumes the primary key is in $values and does not already exist.
    *
    * Uses the DESCRIBE statement so that items in the $values array are
    * only included in the INSERT if a matching column name exists
    * from DESCRIBE. (This is a case-sensitive compare.)
    *
    * @param object  The PDO DB connection
    * @param string  Name of the table to update.
    * @param array   Name/value array of the data to add. Filters out elements
    *                whose names do not appear in $colNames
    * @param array   Array of the names of the columns in $tblName. If left
    *                null, this function will query ask the DB to DESCRIBE its
    *                column names.
    *
    * @return array
    *   First element is the SQL string describing the INPUT command to process.
    *   Second element in another array of the columns used in the query.
    */
   public static function BaseMultiInsert(&$conn, $tblName, $values,
                                          $colNames = null) {
      $insNames = array_keys($values);
      $insVals  = array_values($values);

      $numCols = count($insNames);
      $names = $usedCols = '';

      if ($colNames === null)
         $colNames = QueryBuilder::ColNamesForTable($conn, $tblName);

      for ($ndx = 0; $ndx < $numCols; $ndx++) {
         $curColName = $insNames[$ndx];

         if (!in_array($curColName, $colNames))
            continue;

         // build column names and parameter holders
         $names[]    = "`$curColName`";
         $usedCols[] = $curColName;
      }

      // add commas
      $names = implode(', ', $names);

      $qry = "INSERT INTO $tblName\n ($names)\n VALUES ";

      return array($qry, $usedCols);
   }

   /**
    * Give a single row of possible database values to insert, keyed by column
    * name, along with an array of meta information about the rows we're
    * inserting, creates a simple string for use in a multi-insert statement.
    */
   public static function GetValuesRow(&$pdoDBConn, &$row, $colNames) {
      $vals = array();

      foreach ($row as $col => $val) {
         if (in_array($col, $colNames)) {

            // escape our DB values
            $val = trim($val);

            if ($val == '')
               $vals[] = 'null';
            else
               $vals[] = $pdoDBConn->quote($val);
         }
      }

      if (!empty($vals)) {
         return '(' . implode(', ', $vals) . ')';
      }
      else
         return '';
   }

   /**
    * Get a string of MySQL placeholders, e.g. (?, ?, ?, ?)
    *
    * @param integer  The number of elements in one row to insert.
    * @param integer  The number of columns we're inserting, usually 1.
    *
    * @return string  A string that can be used after the MySQLBaseMultiInsert
    **/
   public static function GetPlaceholders($numElems, $numRows) {
      $rowPlaces = '(' . implode(', ', array_fill(0, $numElems, '?')) . ')';

      return implode(', ', array_fill(0, $numRows, $rowPlaces));
   }

   /**
    * Add the "ON DUPLICATE" clause so the query, if it tries to insert a
    * record with a duplicat key, will instead update the existing row.
    *
    * @param array    Array of string, each of which is the name of a column
    *                 being inserted to in this query.
    **/
   public static function OnDupKeyUpdate($colNames) {
      $qry = "\n    ON DUPLICATE KEY UPDATE ";

      $cols = array();
      foreach ($colNames as $colName) {
         $cols[] = "`$colName` = VALUES(`$colName`)";
      }

      return $qry . implode(', ', $cols);
   }
}
