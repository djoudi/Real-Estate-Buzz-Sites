<?php require_once('./header.inc.php'); ?>

<h2 class="post-entry-title single-title" style="margin: .5em 0;">Search MLS Listings</h2>
<form style="margin: 1em auto; text-align: center;" method="get" action="index.php">
   <input type="search" size="60" max-length="200" name="s" value="<?php if (array_key_exists('s', $_GET)) echo htmlentities($_GET['s']); ?>" placeholder="describe the home you're looking for"/><br />
   <p style="color: #888;"><span style="font-size: 90%;">example:</span> 4 BR 2 bath 1000 sqFt, $300-$450k in San Luis Obispo</p>
   <button type="submit">Search for Homes</button>
</form>

<?php
if (array_key_exists('s', $_GET)) {
   require_once('./lib/mls/MLSModels.inc.php');
   require_once('./lib/mls/MLS_views.inc.php');


   $mdl = new ResidentialModel();
   $view = new MLSResidentialView();

   $res = $mdl->EasySearch($_GET['s']);

   echo "\n<p>Found ", count($res), ' listings.</p>';

   /*
   echo "\n<pre>";
   print_r($res);
   echo "\n</pre>";
    */
   echo $view->ListResults($res);
   /*
   foreach ($res as $listing) {
   }
    */
}

require_once('./footer.inc.php');
