<?php
/**
 * Common base class for repositories that query a database.
 *
 * Contains helper functions for performing PDO queries.
 */
class DBRepository {
   /** Holds a PDO connection object. */
   protected $db;
   /** Name of the main table the repository interfaces with. */
   protected $tblName;
   /** Name of the primary key row. Array of names if more than one. */
   protected $pk;
   /** The debug level for logging errors. */
   protected $logLevel;

   public static $LOG_LEVEL_NONE = 0;
   public static $LOG_LEVEL_ERRORS = 1;
   public static $LOG_LEVEL_DEBUG = 2;
   public static $LOG_LEVEL_QUERY_TIMES = 4;

   /** Name of the connection to a databse in our DBFactory. */
   protected $dbName;

   /**
    * Generic constuctor - sets our db and dbName member data to null.
    *
    *  Base classes *must* call this constructor and then set
    *  their own dbName value.
    *  (The db connection is always created on demand.)
   **/
   public function __construct() {
      $this->dbName  = null;
      $this->tblName = null;
      $this->pk      = null;
      $this->logLevel = DBRepository::$LOG_LEVEL_ERRORS;

      $this->db      = null;
   }

   /**
    * Helper function to log why a particular citation could not be cached.
    *
    * Creates a ./logs directory beneat the current location if none exists.
    *
    * Pass in the docket ID, a message, and optionally the data being
    * inserted.
    */
   public static function WriteToLog($subject, $msg, $data = null) {
      if (!is_dir('./logs'))
         mkdir('./logs');

      $logFile = './logs/query_log.txt';

      $dest = fopen($logFile, 'a');

      $msg = date('Y-m-d H:i:s') . "\t$subject\t$msg";

      if ($data !== null)
         $msg .= "\t" . serialize($data);

      $res  = fwrite($dest, $msg . "\n");
      fclose($dest);
   }

   /**
    * Internal check to make sure we're connected to our database
    * before using the $db object.
    *
    * If we're not connected, we make the connection.
    */
   protected function _assertConnectedToDB() {
      if ($this->db == null) {
         $timeStart = microtime(true);
         $this->db = DBFactory::GetConnection($this->dbName);
         $timeEnd = microtime(true);
         $timeDelta = $timeEnd - $timeStart;

         if (!is_object($this->db)) {
            if ($this->logLevel & self::$LOG_LEVEL_ERRORS)
               self::WriteToLog($this->dbName, $timeDelta, 'Failed to connect');
            die();
         }
         else if ($this->logLevel & self::$LOG_LEVEL_DEBUG)
            self::WriteToLog($this->dbName, $timeDelta, 'Connected');
      }
   }

   /**
    * Prepare and execute a query; return a fetch all of results.
   **/
   protected function _fetchAll($qry, $params = null) {
      $this->_assertConnectedToDB();

      $timeStart = microtime(true);

      $stmt = $this->db->prepare($qry);

      if ($stmt == false) {
         self::WriteToLog($this->dbName,
                          str_replace(array("\n", "\t"), ' ', $qry),
                          $this->db->errorInfo() );
      }

      if ($stmt->execute($params)) {
         $data = $stmt->fetchAll();
         $stmt->closeCursor();

         $timeEnd = microtime(true);

         if ($this->logLevel & self::$LOG_LEVEL_QUERY_TIMES) {
            $timeDelta = $timeEnd - $timeStart;
            self::WriteToLog($this->dbName, $timeDelta,
                             str_replace(array("\n", "\t"), ' ', $qry) );
         }
         return $data;
      }
      else {
         if ($this->logLevel & self::$LOG_LEVEL_ERRORS) {
            self::WriteToLog($this->dbName,
                             str_replace(array("\n", "\t"), ' ', $qry),
                             $stmt->errorInfo() );
         }
         echo "\n<pre>";
         print_r($stmt->errorInfo());
         echo "\n</pre>";
         die();
      }
   }

   /**
    * Prepare and execute a query; return only the first row of the result.
   **/
   protected function _fetchRow($qry, $params = null) {
      $res = $this->_fetchAll($qry, $params);

      if (!empty($res))
         return $res[0];
      else
         return $res;
   }

   /**
    * Prepare and execute a query; results are returned as an associative array
    * where the first column of query is the key to the second column.
    *
    * Only works on 2-column result sets, I think.
    */
   protected function _fetchAssoc($qry, $params = null) {
      $this->_assertConnectedToDB();

      $stmt = $this->db->prepare($qry);
      $stmt->execute($params);

      $data = $stmt->fetchAll(PDO::FETCH_COLUMN | PDO::FETCH_GROUP);
      $stmt->closeCursor();
      return $data;
   }

   /**
    * Prepare and execute a query; results are returned as an associative array
    * where the first column of query is the key to the second column.
    *
    * Only works on 2-column result sets, I think.
    */
   protected function _fetchCol($qry, $params = null) {
      $this->_assertConnectedToDB();

      $stmt = $this->db->prepare($qry);
      $stmt->execute($params);

      $data = $stmt->fetchAll(PDO::FETCH_COLUMN);
      $stmt->closeCursor();
      return $data;
   }

   /**
    * Fetch a single value from a query. Returns the first column of the
    * first row of the query.
    *
    * @param string        The query to execute.
    * @param array|null    Any parameters for the query.
    *
    * @return  string|null The value of the first column of the first row
    *                      of the results, or null if there were no results.
    **/
   protected function _fetchOne($qry, $params = null) {
      $res = $this->_fetchCol($qry, $params);

      if (!empty($res))
         return $res[0];
      else
         return null;
   }

   /**
    * Execute an insert or update query; returns the ID of the inserted row,
    * if available.
    *
    * Determines if this is an update or an insert based on the presence of
    * value in $params['id'].
    *
    * @return array
    *   Array containing the 'success', 'reason' and 'output' of the query.
    *   'output' contains the PK (if atomic) of the data inserted or updated.
    *   If data was deleted it contains the number of rows deleted.
   **/
   protected function _execQuery($qry, $params = null, $pk = null) {
      $res = array('success' => false,
                   'reason'  => 'did not execute the SQL statement',
                   'output'  => null);

      $this->_assertConnectedToDB();

      $timeStart = microtime(true);

      $stmt = $this->db->prepare($qry);

      if (is_object($stmt) AND $stmt->execute($params)) {
         $stmtType = strtoupper(substr($qry, 0, 3));

         if ($stmtType == 'UPD')  // an update
            $output = $pk;
         else if ($stmtType == 'INS')
            $output = $this->db->lastInsertId();
         else   // was probably a DELETE
            $output = $stmt->rowCount();

         $stmt->closeCursor();

         $res['success'] = true;
         $res['reason']  = 'Query executed okay';
         $res['output'] = $output;
      }
      else {
         $errObj = is_object($stmt) ? $stmt : $this->db;

         if ($this->logLevel AND self::$LOG_LEVEL_ERRORS) {
            self::WriteToLog($this->dbName,
                             str_replace(array("\n", '  '), ' ',$qry) . "\t" .
                             serialize($params), $errObj->errorInfo() );
         }
         $errorInfo = $errObj->errorInfo();
         $res['reason']  = $errorInfo[2]; // driver-specific error message
      }

      return $res;
   }

   /**
    * Retrieve all data for a single row from this database table.
    *
    * Assumes that there is a unique column called 'id' that we're
    * using to do our query.
    */
   public function GetForID($id) {
      $qry = "SELECT *
              FROM {$this->tblName}
              WHERE id = ?";
      $params = array($id);

      return $this->_fetchRow($qry, $params);
   }

   /**
    * Save an array of data to the database.
    *
    * Assumes that $data is an array of keys/values where a key corresponds
    * to a column name. If a special key tblName_pk is set (table name,
    * underscore, primary key column name) in this data, then we do an UPDATE
    * instead of an INSERT.
    *
    * This only properly handles Updates where the table's PK is a single value.
    *
    * @param array
    *   Associative array of values to save for this particular item.
    */
   public function Save($data) {
      $this->_assertConnectedToDB();

      $res = array('success' => true,
                   'reason'  => 'Nothing to do.',
                   'output'  => null);

      if (is_array($this->pk)) {
         // no way to deduce if composite keys should be updated or inserted
         // we'll default to insert with an IF EXISTS clause
         $pkVal = null;
         $qrys = QueryBuilder::CreateInsert($this->db, $this->tblName, $data);
      }
      else {
         // special column: IE6 cannot have form elements named 'id', so if
         // that's our PK we send it by convention as '[tblName]_id'
         if ($this->pk === 'id' AND !array_key_exists('id', $data)) {
            $pkName = $this->tblName . '_id';

            if (!array_key_exists($pkName, $data))
               die("must have key named '$pkName' when calling Save()");
         }
         else
            $pkName = $this->pk;

         // the PK is present and not false -> doing an update
         if (array_key_exists($pkName, $data) && $data[$pkName]) {
            $pkVal = $data[$pkName];

            // add the PK (value) under the real PK name if not present
            if (!is_array($this->pk) && !array_key_exists($this->pk, $data))
               $data[$this->pk] = $pkVal;

            $qrys = QueryBuilder::CreateUpdate($this->db, $this->tblName,
                                               $data, $pkVal);
         }
         else { // we're doing an insert
            $pkVal = null;
            $qrys = QueryBuilder::CreateInsert($this->db, $this->tblName,$data);
         }
      }

      // no update necessary when no data fields change
      if (empty($qrys[0])) {
         $res['output'] = $pkVal;
         return $res;
      }
      else {
         return $this->_execQuery($qrys[0], $qrys[1], $pkVal);
      }
   }
}

class ODBCRepository extends DBRepository {

   /**
    * Prepare and execute a query; return a fetch all of results.
   **/
   protected function _fetchAll($qry, $params = null) {
      $this->_assertConnectedToDB();

      $timeStart = microtime(true);

      $stmt = $this->db->query($qry);

      if ($stmt) {
         $data = $stmt->fetchAll();
         $stmt->closeCursor();

         $timeEnd = microtime(true);

         if ($this->logLevel & self::$LOG_LEVEL_QUERY_TIMES) {
            $timeDelta = $timeEnd - $timeStart;
            self::WriteToLog($this->dbName, $timeDelta,
                             str_replace(array("\n", "\t"), ' ', $qry) );
         }
         return $data;
      }
      else {
         if ($this->logLevel & self::$LOG_LEVEL_ERRORS) {
            self::WriteToLog($this->dbName,
                             str_replace(array("\n", "\t"), ' ', $qry) );
         }
         echo "\n<pre>Query failed:\n $qry";
         //print_r($stmt->errorInfo());
         echo "\n</pre>";
         die();
      }
   }
}

/**
 * Sub-repository of our main class which takes advantage of MySQL-specific
 * syntax.
 **/
class MySQLRepository extends DBRepository {

   /**
    * Save (INSERT... ON DUPLICATE KEY UPDATE) an array of data to the database.
    *
    * Assumes that $data is an array of keys/values where a key corresponds
    * to a column name.
    *
    * Limitation: will not work if the table has columns defined as NOT NULL
    * but with no default value - the INSERT syntax checker will halt the query
    * even if you're trying to do an UPDATE.
    *
    * If a special key [tblName]_id is set (table name, * underscore, 'id') in
    * this data, then we remove that value and put it in $data['id'] instead.
    * (This is for a special IE6 workaround.)
    *
    * @param array
    *   Associative array of values to save for this particular item.
    */
   public function Insert($data) {
      $this->_assertConnectedToDB();

      $res = array('success' => true,
                   'reason'  => 'Nothing to do.',
                   'output'  => null);

      // special column: IE6 cannot have form elements named 'id', so if that's
      // our PK we send it by convention as '[tblName]_id'
      if ($this->pk === 'id' && !array_key_exists('id', $data)) {
         $pkName = $this->tblName . '_id';

         if (!array_key_exists($pkName, $data))
            die("must have key named '$pkName' when calling Save()");

         $data['id'] = $data[$pkName];
         unset($data[$pkName]);
      }

      $qb = new MySQLQueryBuilder();
      $colNames = $qb->ColNamesForTable($this->db, $this->tblName);

      foreach ($data as $col => &$val) {
         // empty values are converted to null for DB inserts
         if (trim($val) == '')
            $data[$col] = null;

         if (!in_array($col, $colNames))
            unset($data[$col]);
      }

      $qry = $qb->BaseMultiInsert($this->db, $this->tblName, $data, $colNames);

      $sql = $qry[0] . "\n" . $qb->GetPlaceholders(count($data), 1) .
             $qb->OnDupKeyUpdate($qry[1]);

      //echo "\n<pre>", $sql, '</pre>';
      //printr($data);
      $res = $this->_execQuery($sql, array_values($data));

      //printr($res);
      //die();

      return $res;
   }

   /**
    * Update a row in the database.
    *
    * Creates and executes and SQL update statement for this record.
    * Assumes the primary key is a single value
    *
    * Runs nothing if the update causes no changes in the database.
    * (MySQL returns an error if an UPDATE makes no changes.)
    *
    * Assumes that $data is an array of keys/values where a key corresponds
    * to a column name. If a special key [tblName]_id is set (table name,
    * underscore, 'id') in $data, then it is assumed to be the PK value.
    *
    * @param array
    *   Associative array of values to save for this particular item.
    */
   public function Update($data) {
      $this->_assertConnectedToDB();

      $res = array('success' => true,
                   'reason'  => 'Nothing to do.',
                   'output'  => null);

      // special column: IE6 cannot have form elements named 'id', so if that's
      // our PK we send it by convention as '[tblName]_id'
      if ($this->pk === 'id' AND !array_key_exists('id', $data)) {
         $pkName = $this->tblName . '_id';

         if (!array_key_exists($pkName, $data))
            die("must have key named '$pkName' when calling Save()");
      }
      else
         $pkName = $this->pk;

      // the PK is present and not false
      if (array_key_exists($pkName, $data) AND $data[$pkName]) {
         $pk = $data[$this->tblName . '_' . $this->pk];

         // add the PK (value) under the real PK name if not present
         if (!is_array($this->pk) && !array_key_exists($this->pk, $data))
            $data[$this->pk] = $pk;

         $qrys = QueryBuilder::CreateUpdate($this->db, $this->tblName,
                                            $data, $data[$this->pk]);

         // no update necessary since no fields changed
         if (empty($qrys[0]))
            $res['output'] = $pk;
         else
            $res = $this->_execQuery($qrys[0], $qrys[1], $pk);
      }
      else {
         $res['success'] = false;
         $res['reason'] = 'Cannot update without primary key.';
      }

      return $res;
   }
}
