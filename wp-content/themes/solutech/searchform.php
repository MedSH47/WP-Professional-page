<?php
/*** The html form for search input. ***/
?>

	<form method="get" id="searchform" class="searchform" action="<?php echo esc_url(site_url()) ?>">
		<div>
			<input type="text" placeholder="<?php esc_attr_e('Search', 'solutech');?>" value="<?php esc_attr(the_search_query()); ?>" name="s" id="search">
			<input type="submit" id="searchsubmit" value="">
		</div>
	</form>