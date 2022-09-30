<?php
// init tables for plugin, and methods for render/update settings and donaters
require_once plugin_dir_path(__FILE__) . '__initdb.php';
$donaters = get_vthom_don_donaters();
$settings = get_vthom_don_settings();
/*
 * List all donaters and display with cards
 *
 */
echo "<div style='display: inline-flex; flex-wrap: wrap; gap: 12px;'>";
foreach($donaters as $donater){
	$twitterPerson = false;
	if(isset($settings->twitter_api) 
		&& preg_match('/^@.*/',$donater->name)
		&& $settings->twitter_api != ""
	){

		$sURL = "https://api.twitter.com/2/users/by/username/"
			. str_replace("@","",$donater->name)
			. "?user.fields=profile_image_url"
		;

		$aHTTP['http']['method']  = 'GET';
		$aHTTP['http']['header']  = "Content-Type: application/json\r\n";
		$aHTTP['http']['header'] .= "Authorization: Bearer ".$settings->twitter_api."\r\n";

		$context = stream_context_create($aHTTP);
		$twitterPerson = file_get_contents($sURL, false, $context);
		$twitterPerson = json_decode($twitterPerson) ; 
		// var_dump($twitterPerson) ; // #DEBUG 
	}	

	$profile_image_url = "https://fr.gravatar.com/avatar";
	$donater_name = $donater->name ;
	if($twitterPerson){
		$profile_image_url = $twitterPerson->data->profile_image_url ; 
		$donater_name = "$donater_name<br>" . $twitterPerson->data->name ;
	}

	echo '
	<div class="card" style="width: 15rem;">
	  <img class="card-img-top" src="'.$profile_image_url.'" alt="Donater img">
	  <div class="card-body">
	    <span class="card-text"><small>'.$donater_name.'</small></span>
	    <br>
	    <form method="POST" action="'.admin_url( 'admin.php?page=vthom-acp-page' ).'">
		<input type="hidden" name="id" value="'.$donater->id.'">
	';
	if(is_admin()) {
	    	echo '<button name="table" value="deletedonater" type="submit" class="btn-close float-end" aria-label="Close"></button>' ;
	}
	echo '
	    </form>
	  </div>
	</div>
	' ;
}
echo "</div><!-- .grid -->";
?>
