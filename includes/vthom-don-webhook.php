<?php 
global $vthom_request, $settings ;

// init tables for plugin, and methods for render/update settings and donaters
require_once plugin_dir_path(__FILE__) . '__initdb.php';
$settings = get_vthom_don_settings();

/*
 * some var
 *
 */
$body = $vthom_request->get_body() ; 
$header_hash = $vthom_request->get_header("btcpay_sig");
$secret = $settings->store_secret;
//file_put_contents( plugin_dir_path(__FILE__) .'tmp/headers',$header_hash) ; #DEBUG

/*
 * functions
 *
 */
function getInvoiceDetails($invoiceId){
	global $settings;

	$sURL = $settings->store_url
		. "/api/v1/stores/"
		. $settings->store_id
		. "/invoices/"
		. $invoiceId
		//. "JQWTeafPyLpuRVvjcqdye6" // #DEBUG
	;

	$aHTTP['http']['method']  = 'GET';
	$aHTTP['http']['header']  = "Content-Type: application/json\r\n";
	$aHTTP['http']['header'] .= "Authorization: token ".$settings->api_key."\r\n";

	$context = stream_context_create($aHTTP);
	$invoice = file_get_contents($sURL, false, $context);

	return $invoice ;
}

/* API to convert currency to BTC
 * blockchain.info
 */
function convertCurrencyToBTC($currency,$amount){
	return file_get_contents("https://blockchain.info/tobtc?currency=$currency&value=$amount");
}

/*

/*
 * Webhook receiver callback
 * add a donater if invoice is settled and more than min amount expected
 */
/* BTCPAY SIG 
 * https://docs.btcpayserver.org/API/Greenfield/v1/#operation/Webhooks_CreateWebhook
 */
if(isset($header_hash) &&
        $header_hash == "sha256=".hash_hmac('sha256', $body, $secret)
){
        // add donater 
        //$invoice = json_encode($body) ;
        $BODY = json_decode($body) ;
	//file_put_contents( plugin_dir_path(__FILE__) .'tmp/invoice',$invoice) ; // #DEBUG
	//file_put_contents( plugin_dir_path(__FILE__) .'tmp/invoiceType',$BODY->type) ; // #DEBUG
	// only take InvoiceSettled (which is actually paid and terminate)
	if($BODY->type == "InvoiceSettled"){
		$invoiceId = $BODY->invoiceId ;
		//file_put_contents( plugin_dir_path(__FILE__) .'tmp/invoiceIdInIf',$invoiceId) ; // #DEBUG
		$invoice = json_decode(getInvoiceDetails($invoiceId)) ;
		$invoiceInBTC = ( strtolower($invoice->currency) != "btc" ) ? 
			convertCurrencyToBTC($invoice->currency,$invoice->amount) :
		       	$invoice->amount;  
		$minDonInBTC = ( strtolower($settings->don_currency) != "btc" ) ? 
			convertCurrencyToBTC($settings->don_currency,$settings->don_min) : 
		    	$settings->don_min;  
		/*
		if(intval($invoice->amount) > $settings->don_min 
			&& 
			$invoice->currency == $settings->don_currency
		){
 		*/
		if(floatval($invoiceInBTC) >= floatval($minDonInBTC)){

			$donater = $invoice->metadata->itemDesc ;
			if(is_string($donater) && $donater != ""){
				//file_put_contents( plugin_dir_path(__FILE__) .'tmp/invoiceDonater',json_encode($donater)) ; // #DEBUG
				if(!add_vthom_donater($donater)){
					echo json_encode(["message" => "update error"]);
				}else{
					echo json_encode(["message" => "update success"]) ;
				}
			}else{
				echo json_encode(["message" => "no update. no name for donater"]) ;
			}
		}else{
			echo json_encode(["message" => "invoice well received but not enough amount to be a donater"]) ;
		}
	}
		echo json_encode(["message" => "only for InvoiceSettled"]) ;
}else{
	echo json_encode(["message" => "ERROR: you're not supposed to do that !"]);
}

?>
