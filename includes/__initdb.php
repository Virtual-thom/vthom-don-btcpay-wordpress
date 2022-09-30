<?php

/**
 * Si inexistante, on crée la table SQL 
 */

global $wpdb, $vthom_don_settings_table_name, $vthom_don_donaters_table_name;
$charset_collate = $wpdb->get_charset_collate();

// TABLES NAMES 
$vthom_don_settings_table_name = $wpdb->prefix . 'vthom_don_settings';
$vthom_don_donaters_table_name = $wpdb->prefix . 'vthom_don_donaters';
$TABLE = array(
	"settings" => $vthom_don_settings_table_name,
	"deletedonater" => $vthom_don_donaters_table_name,
	"donaters" => $vthom_don_donaters_table_name
);

/**
 * init table
 */
$vthom_don_settings_sql = "CREATE TABLE IF NOT EXISTS $vthom_don_settings_table_name (
	id tinyint NOT NULL AUTO_INCREMENT,
	store_id varchar(255),
	store_url varchar(255),
	store_secret varchar(255),
	twitter_api varchar(255),
	don_currency varchar(5),
	don_min int,
	api_key varchar(255),
	PRIMARY KEY  (id)
) $charset_collate;";


$vthom_don_donaters_sql = "CREATE TABLE IF NOT EXISTS $vthom_don_donaters_table_name (
	id int NOT NULL AUTO_INCREMENT,
	twitter boolean,
	name varchar(45),
	PRIMARY KEY  (id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

dbDelta($vthom_don_settings_sql);
dbDelta($vthom_don_donaters_sql);
/******************************************************/

/**
 * récupération des settings pour affichage dans vthom_don_settings page
 */
function get_vthom_don_settings() {
	global $wpdb ; 
	global $vthom_don_settings_table_name ;

	$sql = $wpdb->prepare("
		SELECT
		store_id,
		store_url,
		store_secret,
		don_currency,
		don_min,
		twitter_api,
		api_key
		FROM $vthom_don_settings_table_name 
		WHERE id = 1
		"
	);
	return $wpdb->get_row($sql) ;
}

/**
 * récupération des donaters 
 */
function get_vthom_don_donaters() {
        global $wpdb ;
        global $vthom_don_donaters_table_name ;

        $sql = $wpdb->prepare("
                SELECT
		id,
		name
                FROM $vthom_don_donaters_table_name
                "
        );
        return $wpdb->get_results($sql) ;
}

/*
 * ajout d'un donater
 *
 */
function add_vthom_donater($donater){
	global $wpdb ;
        global $vthom_don_donaters_table_name ;

	return $wpdb->insert($vthom_don_donaters_table_name, array(
			"name" => $donater
		)
	);
}


/*
 * Update tables if POST
 *
 */
if($_SERVER["REQUEST_METHOD"] == "POST"){
	global $wpdb ;
	
	$POSTTABLE = $_POST["table"] ;	
	unset($_POST["table"]) ;

	$table = $TABLE[$POSTTABLE];

	$values = $_POST ;

	if($POSTTABLE == "settings") { $values["id"] = 1 ;}
	
	if($POSTTABLE == "deletedonater"){
		$wpdb->delete($table,$values);
	}else{
		$wpdb->replace($table,$values);
	}
}

