<?php
/**
 * Class which can display a variety of HTML views of MLS listings.
 **/
class MLSResidentialView {

   /**
    * Display a short summary of the results of a query.
    *
    * Usually used for displaying a short summary in the WP blog posting.
    *
    * @param array   An array of database query results.
    * @return string HTML that may be displayed on a web page.
    **/
   public function ListResults(&$listing) {
      if (empty($listing))
         return "\n<p>Sorry, no results currently match.</p>";

      $str = '';

      foreach ($listing as $home) {
         $str .= "\n<div><h3>{$home['num_bedrooms']}BR / " .
            "{$home['num_bathrooms']}Bath" . "</h3>";

         $str .= "<h4>$" . number_format($home['listing_price']) . '</h4>';

         $str .= "<h4>" . number_format($home['sq_footage']) . ' sqFt. / ' .
            $home['story_type_lvl'];
         if ($home['year_built'])
            $str .= ' / built ' . $home['year_built'];
         $str .= '</h4>';

         $str .= "<p>" . nl2br(htmlspecialchars($home['marketing_remarks'])) . '</p>';

         if ($home['virtual_tour_url']) {
            $url = htmlspecialchars($home['virtual_tour_url']);
            $str .= "\n<p><a href=\"$url\">Virtual Tour" .
               '</a></p>';
         }

         if ($home['pictures_count'] > 0) {
            $str .= "\n<div style=\"float: left; width: 49%;\">";
            $str .= "<a href=\"\">";
            $str .= "<img src=\"/images-mls/{$home['ml_id']}.jpg\" alt=\"\" style=\"width: 100%;\" />";
            $str .= "</a></div>";
         }

         if ($home['show_addr_to_public'] == 'Y') {
            $str .= "\n<div style=\"float: right; width: 50%;\">";
            $str .= "\n<h4>Address</h4>";
            $str .= '<p>' . $home['street_num'] . ' ' .
               $home['street_direction'] . ' ' .
               $home['street_name'] . ' ' .
               $home['street_suffix'];

            if ($home['unit'])
               $str .= ' Unit ' . $home['unit'];

            $str .= '<br/>' . $home['city'] . ' ' . $home['state'] . ' ' .
               $home['zip'];
            $str .= "\n</p></div>";
         }

         $str .= "\n<p>Contact {$home['agent_name']} of {$home['office_name']} at {$home['listing_office_phone']}.</p>";

         $str .= "\n</div><hr style=\"clear: both; color: #666; background-color: #666; border-top: 1px dashed #666; width: 80%;\" />";
      }

      return $str;
   }
}
