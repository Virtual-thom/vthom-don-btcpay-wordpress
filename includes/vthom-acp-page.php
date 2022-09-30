<?php
/*
 *  Bootstrap Styles and scripts
 */
wp_register_style( 'bootstrap',  plugins_url('bootstrap/css/bootstrap.min.css',__FILE__ ) );
wp_register_script( 'bootstrap',  plugins_url('bootstrap/js/bootstrap.bundle.min.js',__FILE__ ) );
wp_enqueue_style('bootstrap');
wp_enqueue_script('bootstrap');


?>

<div class="wrap">

<ul class="nav nav-tabs" id="adm-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="donaters-tab" data-bs-toggle="tab" data-bs-target="#donaters" type="button" role="tab" aria-controls="donaters" aria-selected="false">Donaters</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="true">Settings</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="doc-tab" data-bs-toggle="tab" data-bs-target="#doc" type="button" role="tab" aria-controls="doc" aria-selected="false">Doc</button>
  </li>
</ul>

<div class="tab-content">
  <div class="tab-pane fade show active" id="donaters" role="tabpanel" aria-labelledby="donaters-tab" tabindex="0">
	<?php include 'vthom-don-donaters.php'; ?>	
</div>
  <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab" tabindex="0">
	<?php include 'vthom-don-settings.php'; ?>	
</div>
  <div class="tab-pane fade" id="doc" role="tabpanel" aria-labelledby="doc-tab" tabindex="0">
 <a href="https://github.com/Virtual-thom/vthom-don-btcpay-wordpress/blob/main/README.md" >https://github.com/Virtual-thom/vthom-don-btcpay-wordpress/blob/main/README.md</a>	
</div>
</div>


</div> <!-- .wrap -->
