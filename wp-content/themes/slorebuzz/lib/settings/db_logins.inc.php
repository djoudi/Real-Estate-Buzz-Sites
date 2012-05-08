<?php
/**
 * DB Logins to all our various databases.
 *
 * This file is sensitive - it should *not* be tracked in version control,
 * nor stored on a server without the best possible lock-down settings.
 *
 * @author  James Van Lommel <james.vanlommel@slo.courts.ca.gov>
 * @package IncludeFiles
 * @subpackage DBConnections
*/

class DBLogins {

   public static $tableSuffix = '';
   public static $dbServ      = 'server_name';

   protected static $user = 'user_name';
   protected static $pass = 'pw';

   protected static $pw   = '32nm#0Zj_Tnj2';
   protected static $salt = '85)!_A';

   private $logins;

   public function __construct() {
      $this->logins = array(
       'fam_re_buzz'             => array(self::$user, self::$pass, 'mysql'),
       'web_statusboard' => array('na',   'na',   'sqlite')
      );
   }

    public function __get($key) {
       $statics = array('user', 'pass', 'pw', 'salt', 'tableSuffix', 'dbServ');

       if (in_array($key, $statics))
          return self::$$key;
       else if (array_key_exists($key, $this->logins))
          return $this->logins[$key];

      return null;
   }

   public function __isset($key) {
       $statics = array('user', 'pass', 'pw', 'salt', 'tableSuffix', 'dbServ');

       return in_array($key, $statics) OR array_key_exists($key, $this->logins);
   }
}
