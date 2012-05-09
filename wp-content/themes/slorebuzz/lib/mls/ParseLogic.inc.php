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

class ResidentialModel extends MySQLRepository {
   public $cols;

   public function __construct() {
      parent::__construct();

      $this->dbName = 'fam_re_buzz';
      $this->tblName = 'mls_listings';
      $this->pk = 'id';

      $this->cols = array('ml_id' => 0,
         'possession' => 90,
         'acres' => 1,
         'sq_footage' => 3,
         'listing_price' => 8,

         'num_bedrooms' => 102,
         'num_bathrooms' => 2,
         'rooms' => 40,
         'full_bath' => 4,
         'half_bath' => 5,
         'qtr_bath' => 6,
         'garage_spaces' => 11,
         'pets' => 101,

         'prop_subtype' => 103,
         'story_type_lvl' => 66,
         'zone_description' => 18,
         'year_built' => 30,
         'pictures_count' => 125,
         'virtual_tour_url' => 115,

         'show_addr_to_public' => 114,
         'street_num' => 20,
         'street_num_modifier' => 21,
         'street_direction' => 22,
         'street_name' => 23,
         'steet_suffix' => 24,
         'unit' => 25,
         'city' => 26,
         'state' => 27,
         'zip' => 28,
         'zip_4' => 29,
         'county' => 120,

         'hoa' => 45,
         'hoa_fee' => 48,
         'hoa_fee_paid' => 54,

         'office_id' => 107,
         'office_name' => 106,
         'listing_office_phone' => 33,
         'agent_id' => 57,
         'agent_full_name' => 58,
         'agent_name' => 121,
         'agent_number' => 123,
         'agent_phone' => 124,
         'agent_phone_type' => 122,

         'marketing_remarks' => 9,
         'appliances_incld' => 34,
         'entry_date' => 92);
   }

   /**
    * Map an array of CSV MLS data to an associative array, suitable for
    * inserting to our database.
    *
    * @param array   A numerically indexed array of one row from the MLS CSV.
    * @return array  An associative array of data for this data model.
    **/
   public function mapCSVtoDB($csvData) {
      $data = array();

      foreach ($this->cols as $name => $ndx) {
         if ($ndx !== null)
            $data[$name] = $csvData[$ndx];
         else
            $data[$name] = null;
      }

      $this->CleanDBData($data);

      return $data;
   }

   public function CleanDBData(&$data) {
      $data['entry_date'] = date('Y-m-d', strtotime($data['entry_date']));
      $data['last_update'] = date('Y-m-d H:i:s');

      if ($data['show_addr_to_public'] == 1)
         $data['show_addr_to_public'] = 'Y';
      else
         $data['show_addr_to_public'] = 'N';

      if (strlen($data['zip']) > 5)
         $data['zip'] = substr($data['zip'], 0, 5);

      if ($data['zip_4'] < 0)
         $data['zip_4'] = null;

      $data['mls_listings_id'] = $this->idFromMLSid($data['ml_id']);
   }

   public function idFromMLSid($mlsID) {
      $qry = "SELECT id
                FROM {$this->tblName}
               WHERE ml_id = ?";

      $params = array($mlsID);
      return $this->_fetchOne($qry, $params);
   }

   /**
    * Do a basic search for listings based on number of bedrooms, bathrooms,
    * and/or price of the listing.
    *
    * @param array   An associative array which may contain any of the
    *                following. Any not present, empty, or set to 0 will be
    *                ignored.
    *
    *                'bed' - min # of bedrooms in the listing
    *                'bath' - min # of bathrooms
    *                'sq_ft' - min # of square feet
    *
    *                'price' - approximate price of the listing, +/- 10%
    *                'price_min' - minimum price
    *                'price_max' - maximum price
    *
    *                'city' - city it appears in
    *                'zip' - zip it resides in
    *
    * @return array  Results from the query.
    **/
   public function HomeSearch($searchParams) {
      $qry = "SELECT *
                FROM {$this->tblName}
               WHERE ";
      $params = array();
      $filters = array();

      foreach ($searchParams as $name => $val) {
         if (empty($val) || $val === 0)
            continue;

         switch ($name) {
         case 'bed':
            $filters[] = " num_bedrooms >= ?";
            $params[] = $val;
            break;
         case 'bath':
            $filters[] = " num_bathrooms >= ?";
            $params[] = $val;
            break;
         case 'price':
            $filters[] = " listing_price BETWEEN ? AND ?";
            $params[] = $val - ($val * .1);
            $params[] = $val + ($val * .1);
            break;
         case 'price_min':
            $filters[] = " listing_price >= ?";
            $params[] = $val;
            break;
         case 'price_max':
            $filters[] = " listing_price <= ?";
            $params[] = $val;
            break;
         case 'city':
            $filters[] = " city = ?";
            $params[] = $val;
            break;
         case 'zip':
            $filters[] = " zip = ?";
            $params[] = $val;
            break;
         }
      }

      // won't do query for everything - must filter
      if (count($filters) == 0)
         return array();

      $qry .= implode(' AND ', $filters);

      $qry .= " ORDER BY listing_price";

      $res = $this->_fetchAll($qry, $params);

      return $res;
   }
}
