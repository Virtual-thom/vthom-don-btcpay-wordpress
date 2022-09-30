<?php

/*
 * form add donater manually
 *
 */
?>
<form class="mt-3 container" method="post" action="<?php echo admin_url( 'admin.php?page=vthom-acp-page' ); ?>">
  <div class="row mb-3">
    <label for="name" class="col-sm-2 col-form-label">Nom</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="name" name="name" placeholder="@usertwitter ou Pseudo ou nom">
    </div>
  </div>

  <button type="submit" class="btn btn-primary" name="table" value="donaters">Add</button>
</form>
<h1>Shortcode to use in your pages "[vthom_don_shortcode_donaters]"</h1>
<br>
<?php
echo do_shortcode("[vthom_don_shortcode_donaters]");
