<?php
require_once('../mls/ParseLogic.inc.php');

class StackTest extends PHPUnit_Framework_TestCase {

   protected function setUp() {
      $this->mdl = new MLSLangQueryParser();
   }

   /**
    * @dataProvider provider
   */
   public function testBed($qryStr, $expected) {
      $res = $this->mdl->ParseSearch($qryStr);
      $term = 'bed';

      if (array_key_exists($term, $expected)) {
         $this->assertTrue(array_key_exists($term, $res));
         $this->assertEquals($expected[$term], $res[$term]);
      }
      else {
         $this->assertFalse(array_key_exists($term, $res));
      }
   }

   /**
    * @dataProvider provider
   */
   public function testBath($qryStr, $expected) {
      $res = $this->mdl->ParseSearch($qryStr);
      $term = 'bath';

      if (array_key_exists($term, $expected)) {
         $this->assertTrue(array_key_exists($term, $res));
         $this->assertEquals($expected[$term], $res[$term]);
      }
      else {
         $this->assertFalse(array_key_exists($term, $res));
      }
   }

   /**
    * @dataProvider provider
   */
   public function testSquareFeet($qryStr, $expected) {
      $res = $this->mdl->ParseSearch($qryStr);
      $term = 'sq_ft';

      if (array_key_exists($term, $expected)) {
         $this->assertTrue(array_key_exists($term, $res));
         $this->assertEquals($expected[$term], $res[$term]);
      }
      else {
         $this->assertFalse(array_key_exists($term, $res));
      }
   }

   /**
    * @dataProvider provider
   */
   public function testPriceMin($qryStr, $expected) {
      $res = $this->mdl->ParseSearch($qryStr);
      $term = 'price_min';

      if (array_key_exists($term, $expected)) {
         $this->assertTrue(array_key_exists($term, $res));
         $this->assertEquals($expected[$term], $res[$term]);
      }
      else {
         $this->assertFalse(array_key_exists($term, $res));
      }
   }

   /**
    * @dataProvider provider
   */
   public function testPriceMax($qryStr, $expected) {
      $res = $this->mdl->ParseSearch($qryStr);
      $term = 'price_max';

      if (array_key_exists($term, $expected)) {
         $this->assertTrue(array_key_exists($term, $res));
         $this->assertEquals($expected[$term], $res[$term]);
      }
      else {
         $this->assertFalse(array_key_exists($term, $res));
      }
   }

   /**
    * @dataProvider provider
   */
   public function testPrice($qryStr, $expected) {
      $res = $this->mdl->ParseSearch($qryStr);
      $term = 'price';

      if (array_key_exists($term, $expected)) {
         $this->assertTrue(array_key_exists($term, $res));
         $this->assertEquals($expected[$term], $res[$term]);
      }
      else {
         $this->assertFalse(array_key_exists($term, $res));
      }
   }

   /**
    * @dataProvider provider
   */
   public function testCity($qryStr, $expected) {
      $res = $this->mdl->ParseSearch($qryStr);
      $term = 'city';

      if (array_key_exists($term, $expected)) {
         $this->assertTrue(array_key_exists($term, $res));
         $this->assertEquals($expected[$term], $res[$term]);
      }
      else {
         $this->assertFalse(array_key_exists($term, $res));
      }
   }

   /**
    * @dataProvider provider
   */
   public function testZip($qryStr, $expected) {
      $res = $this->mdl->ParseSearch($qryStr);
      $term = 'zip';

      if (array_key_exists($term, $expected)) {
         $this->assertTrue(array_key_exists($term, $res));
         $this->assertEquals($expected[$term], $res[$term]);
      }
      else {
         $this->assertFalse(array_key_exists($term, $res));
      }
   }

   public function provider() {
      return array(array('4 BR $10,000-$50,000',
            array('bed' => 4, 'price_min' => 10000, 'price_max' => 50000)),

         array(' 2 bath, 3 bedroom, $400k',
            array('bed' => 3, 'bath' => 2, 'price' => 400000)),

         array('4br 2ba 1500sf, $200k - $400k',
            array('bed' => 4, 'bath' => 2, 'sq_ft' => 1500, 
                  'price_min' => 200000, 'price_max' => 400000)),

         array('1br 1ba 150sqft, $125-150k',
               array('bed' => 1, 'bath' => 1, 'sq_ft' => 150,
                  'price_min' => 125000, 'price_max' => 150000)),

         array('12 br 125 ba 400 sq ft in 93401',
            array('bed' => 12, 'bath' => 125, 'sq_ft' => 400,
                  'zip' => '93401')),

         array('2br 2ba 600 sqFeet 93405',
               array('bed' => 2, 'bath' => 2, 'sq_ft' => 600,
                  'zip' => '93405')),

         array(' 3 bathroom 1,000 Square Feet 3 bedroom in Arroyo Grande',
               array('bed' => 3, 'bath' => 3, 'sq_ft' => 1000,
                  'city' => 'Arroyo Grande')),

         array('2 bath 10,000 sq ft in 93401 $300,000',
               array('bath' => 2, 'sq_ft' => 10000, 'zip' => '93401',
                  'price' => 300000)),

         array('4BR 2BA 1,200 SF $200-$250k in San Luis Obispo on Johnson',
            array('bed' => 4, 'bath' => 2, 'sq_ft' => 1200,
                  'price_min' => 200000, 'price_max' => 250000,
                  'city' => 'San Luis Obispo', 'street' => 'Johnson')),
      );
   }
}
