<?php
$donors = btcpay_donors_get_donors();

function btcpay_donors_get_donor_image($donor_name)
{
  $btcpay_donors_options = get_option("btcpay_donors");
  $profile_image_url = "https://fr.gravatar.com/avatar";
  if (
    isset($btcpay_donors_options["twitter_bearer_token"]) &&
    preg_match("/^@.*/", $donor_name) &&
    $btcpay_donors_options["twitter_bearer_token"] != ""
  ) {
    $url = "https://api.twitter.com/1.1/users/show.json?screen_name=" . str_replace("@", "", $donor_name);
    $args = [
      "headers" => [
        "Content-Type" => "application/json",
        "Authorization" => "Bearer " . $btcpay_donors_options["twitter_bearer_token"],
      ],
    ];

    $response = wp_remote_get($url, $args);
    $body = wp_remote_retrieve_body($response);
    $user = json_decode($body);
    if ($user) {
      $profile_image_url = preg_replace('/^(.*)_normal\.(.*)$/', '${1}.${2}', $user->profile_image_url);
    }
  }
  return $profile_image_url;
}
?>
<div class="donors-container">
    <?php foreach ($donors as $donor): ?>
        <div class="donor-card">
            <img class="donor-img" src="<?php echo btcpay_donors_get_donor_image($donor->name); ?>" alt="<?php echo $donor->name; ?>'s picture">
            <span class="donor-name"><?php echo $donor->name; ?></span>
            <?php if (is_admin()): ?>
                <form method="POST" action="<?php echo esc_url(admin_url("admin-post.php")); ?>">
                    <input type="hidden" name="id" value="<?php echo $donor->id; ?>">
                    <input type="hidden" name="action" value="btcpay_donors_delete_donor">
                    <input type="hidden" name="delete_donor_meta_nonce" value="<?php echo wp_create_nonce("delete_donor_meta_form_nonce"); ?>" />
                    <button type="submit">Delete</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<style>
.donors-container {
    display: inline-flex;
    flex-wrap: wrap;
    gap: 12px;
}
.donor-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}
.donor-img {
    border-radius: 50%;
    display: block;
    width: 120px;
}

<?php
$btcpay_donors_options = get_option("btcpay_donors");
if (!is_admin() && isset($btcpay_donors_options["custom_css"]) && $btcpay_donors_options["custom_css"] != "") {
  echo $btcpay_donors_options["custom_css"];
}
?>
</style>