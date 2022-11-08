<?php
/*
 * form add donor manually
 */
?>
<h1>Donors</h1>

<div>
  <h2>Add a donor</h2>
  <form class="" method="post" action="<?php echo esc_url(admin_url("admin-post.php")); ?>" id="add_donor_meta_form">
    <div class="flex">
      <input required type="text" id="name" name="name" placeholder="@decouvrebitcoin">
      <button type="submit" class="form-button">Add</button>
    </div>

    <input type="hidden" name="action" value="btcpay_donors_add_donor">
    <input type="hidden" name="add_donor_meta_nonce" value="<?php echo wp_create_nonce("add_donor_meta_form_nonce"); ?>" />
  </form>
</div>

<div>
  <h2>Donors list</h2>
  <?php echo do_shortcode("[btcpay_donors_shortcode_donors]"); ?>
</div>
<br>

<style>
input[type=text] {
  width: 500px;
  padding: 5px 12px;
  box-sizing: border-box;
}

.form-button {
  position: relative;
  right: 65px;
  background-color: #4CAF5030; /* Green */
  border: 2px solid #4CAF50;
  border-radius: 4px;
  color: black;
  padding: 5px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.form-button:hover {
  background-color: #4CAF50; /* Green */
  color: white;
}

.flex {
  display: flex;
  flex-direction: row;
  align-items: center;
}
</style>
