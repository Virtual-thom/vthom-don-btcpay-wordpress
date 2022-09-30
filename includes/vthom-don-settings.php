<?php 
// init tables for plugin, and methods for render/update settings and donaters
require_once plugin_dir_path(__FILE__) . '__initdb.php';
$settings = get_vthom_don_settings();
?>
<form class="mt-3" method="post" action="<?php echo admin_url( 'admin.php?page=vthom-acp-page' ); ?>">
  <div class="row mb-3">
    <label for="store_id" class="col-sm-2 col-form-label">STORE ID</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="store_id" name="store_id" value="<?php echo $settings->store_id ?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="store_url" class="col-sm-2 col-form-label">STORE URL</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="store_url" name="store_url"  value="<?php echo $settings->store_url ?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="store_secret" class="col-sm-2 col-form-label">STORE SECRET</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="store_secret" name="store_secret"  value="<?php echo $settings->store_secret ?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="api_key" class="col-sm-2 col-form-label">BTCPAY API KEY</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="api_key" name="api_key"  value="<?php echo $settings->api_key ?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="don_min" class="col-sm-2 col-form-label">MIN AMOUNT of Donation</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="don_min" name="don_min" value="<?php echo $settings->don_min ?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="don_currency" class="col-sm-2 col-form-label">CURRENCY (for MIN AMOUNT)</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="don_currency" name="don_currency" value="<?php echo $settings->don_currency ?>">
    </div>
  </div>
  <div class="row mb-3">
    <label for="twitter_api" class="col-sm-2 col-form-label">TWITTER API</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="twitter_api" name="twitter_api" value="<?php echo $settings->twitter_api ?>">
    </div>
  </div>

  <button type="submit" class="btn btn-primary" name="table" value="settings">Save settings</button>
</form>

