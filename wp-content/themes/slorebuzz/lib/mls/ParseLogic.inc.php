<?php
class MLSParser {
   public $db;

   /**
    * Construct an instance of the MLS Parser that will save data to $db.
    *
    * @param object   An instance of the DBRepository class.
    **/
   public function __construct($db) {
      $this->db = $db;
   }

   public function parseCSV($fileName) {

      $filePortion = basename($fileName, '.csv');
      if (substr($filePortion, 0, 4) != 'RESI') {
         echo "not a residential listing - skipping\n";
         return;
      }

      echo "\nopening " . realpath($fileName);
      $fHandle = fopen($fileName, 'r');

      if ($fHandle === false)
         die('could not open file for parsing: ' . $fileName);

      $qb = new MySQLQueryBuilder();

      $row = 0;
      $qry = $params = $colNames = null;

      while (($data = fgetcsv($fHandle)) !== false) {
         if ($row == 0) {
            $row++;
            continue;
         }
         //$num = count($data, 2100);

         //echo "$num fields in line $row\n";
         $dbData = $this->db->mapCSVtoDB($data);

         /*
         if ($colNames === null) {
            $qryInfo = $qb->BaseMultiInsert($this->db, 'mls_listings', $dbData);

            $qry = $qryInfo[0];
            $colNames = $qryInfo[1];
         }
         */

         $res = $this->db->Insert($dbData);

         if (!$res['success']) {
            print_r($dbData);
            print_r($res);
            die();
         }

         //print_r($dbData);
         //echo "\n";

         $row++;
      }

      fclose($fHandle);
   }
}

/**
 * Parse natural-language queries.
 **/
class MLSLangQueryParser {

   /**
    * Parse a human-created query for listings to a data structure
    * suitable for passing to any of our models.
    **/
   public function ParseSearch($searchStr) {
      $params = $matches = array();
      $searchStr = str_replace(',', '', $searchStr);

      // bedrooms
      $res = preg_match('/([\d]+)\s?(?:br|bed)/i', $searchStr, $matches);

      if ($res) {
         $params['bed'] = $matches[1];
         $searchStr = str_replace($matches[0], '', $searchStr);
      }

      // bathrooms
      $res = preg_match('/([\d]+)\s?(?:ba[\w]?)/i', $searchStr, $matches);

      if ($res) {
         $params['bath'] = $matches[1];
         $searchStr = str_replace($matches[0], '', $searchStr);
      }

      // sq. footage
      $res = preg_match('/([\d]+)\s?(?:sq[\w]?|sf)/i', $searchStr, $matches);

      if ($res) {
         $params['sq_ft'] = $matches[1];
         $searchStr = str_replace($matches[0], '', $searchStr);
      }

      //price min and mx
      $res = preg_match('/\$([\d]+)k?\s?-\s?\$?([\d]+)(k?)/i', $searchStr, $matches);

      if ($res) {
         if ($matches[3] == 'k')
            $mult = 1000;
         else
            $mult = 1;

         $params['price_min'] = $matches[1] * $mult;
         $params['price_max'] = $matches[2] * $mult;

         $searchStr = str_replace($matches[0], '', $searchStr);
      }

      //price
      $res = preg_match('/\$([\d]+)(k?)(?:\s|$)/i', $searchStr, $matches);

      if ($res) {
         if ($matches[2] == 'k')
            $mult = 1000;
         else
            $mult = 1;

         $params['price'] = $matches[1] * $mult;

         $searchStr = str_replace($matches[0], '', $searchStr);
      }

      // zip
      $res = preg_match('/(?:in )?([\d]{5})(?: |$)/i', $searchStr, $matches);

      if ($res) {
         $params['zip'] = $matches[1];
         $searchStr = str_replace($matches[0], '', $searchStr);
      }

      // city
      $res = preg_match('/in (\D+?)(?: on |$)/i', $searchStr, $matches);

      if ($res) {
         $params['city'] = $matches[1];
         $searchStr = str_replace($matches[0], '', $searchStr);
      }

      return $params;
   }
}
