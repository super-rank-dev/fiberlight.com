<?php
/* Custom search form */
?>
<form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="input-group mb-3">
  <div class="input-group">
    <input type="search" class="form-control border-0" placeholder="Search" aria-label="search" name="s" id="search-input" value="<?php echo esc_attr( get_search_query() ); ?>">

    <button id="btn-submit" type="submit" class="btn btn-primary">
    </button>
  </div>
</form>