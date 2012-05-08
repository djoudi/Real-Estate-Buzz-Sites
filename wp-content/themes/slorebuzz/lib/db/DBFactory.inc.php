<?php


/**
 * DB Connection Factory object. Creates connections to requested databaes.
 *
 * @author  James Van Lommel <james.vanlommel@slo.courts.ca.gov>
 * @package IncludeFiles
 * @subpackage DBConnections
*/
class DBFactory {

   /**
    * Returns a PDO connection object to the specified database table.
    *
    * Can create a PDO object connected to MySQL, Postgres, MS SQL Server,
    * mainframe (via ODBC), Sustain (via ODBC), and local SQLite databases.
    *
    * Assumes certain conventions about the database schema names we're
    * connecting to - i.e. that MySQL and Postgres database names all have
    * a suffix, etc.
    *
    * Assumes SQLite databases are stored under the './data' directory
    * of the current web app, and end with the '.sq3' extension.
    *
    * Assumes the current instance of PHP has the necessary PDO extensions
    * installed.
    *
    * @param string
    *  Name of the database table to connect to. Table name must exist in
    *  the $logins array.
    */
   public static function GetConnection($dbName) {
      $logins = new DBLogins();

      if (!isset($logins->$dbName)) {
         echo "\n<p>Sorry, but there's no connection info for $dbName.</p>";
         return null;
      }

      $creds = $logins->$dbName;
      $dbUser = $creds[0];
      $dbPass = $creds[1];
      $dbType = $creds[2];

      if ('none' == $dbUser) $dbUser = $logins->user;
      if ('none' == $dbPass) $dbPass = $logins->pass;

      // Set fetch mode to always by associative.
      // Might some day also use, PDO::ATTR_CASE => PDO::CASE_LOWER, array
      //  but this changes column names for MS SQL tables.
      $opts = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

      try {
         if ($dbType == 'mysql') {
            $dbName = $dbName . $logins->tableSuffix;
            $dsn    = 'mysql:host=' . $logins->dbServ . ';dbname=' . $dbName .
                      ';charset=utf8';

            // get rid of "MySQL Server has gone away" error message?
            $opts[PDO::ATTR_PERSISTENT] = true;
            $opts[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
            $opts[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';

            $pdo = new PDO($dsn, $dbUser, $dbPass, $opts);
         }
         else if ($dbType == 'postgres') {
            $schema = str_replace('_pg', '', $dbName) . $logins->tableSuffix;
            $dbName = 'slocourt';
            $dsn = 'pgsql:host=localhost port=5432 dbname=' . $dbName;

            $opts[PDO::ATTR_PERSISTENT] = true;

            $pdo = new PDO($dsn, $dbUser, $dbPass, $opts);
            $qry = "SET search_path TO \"$schema\"";
            $stmt = $pdo->prepare($qry);
            $res = $stmt->execute();

            if (!$res)
               die('Could not set search_path to ' . $schema);
         }
         else if ($dbType == 'sqlite') {
            global $_APP;
            $dsn = 'sqlite:' . $_APP['dir.base'] . 'data/' . $dbName . '.sq3';
            $pdo = new PDO($dsn, '', '', $opts);
         }
      }
      catch (PDOException $e) {
         $msg = $e->getMessage();

         echo "\n<div class=\"noteimportant\">Sorry, but we can't seem to
         connect to the $dbName DB right now.<br/>
         <br /> Last message: $msg.
         </div>";

         return null;
      }

      return $pdo;
   }

   /**
    * Returns associative array used by BackupDB class to pass credentials
    * to mysqladmin.exe.
    *
    * @param string
    *  Name of the database table to connect to. Table name must exist in
    *  the $logins array.
    */
   public static function GetCredentials($dbName) {
      $logins = new DBLogins();

      if (!isset($logins->$dbName)) {
         echo "\n<p>Sorry, but there's no connection info for $dbName.</p>";
         return null;
      }

      $creds = $logins->$dbName;

      return array('-u ' => $creds[0],
                   '-p'  => $creds[1],
                   '-h ' => $logins->$dbServ);
   }

   /**
    * Get a password used for reversible encryption on this server.
    * Typically used by BackupDB class to encrypt backups.
    */
   public static function GetPassword() {
      $logins = new DBLogins();
      return $logins->pw;
   }

   /**
    * Get salt used for reversible encryption on this server.
    * Typically used by BackupDB class to create hashes.
    */
   public static function GetSalt() {
      $logins = new DBLogins();
      return $logins->salt;
   }
}
