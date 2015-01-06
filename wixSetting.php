<?php

add_action( 'admin_init', 'wix_admin_init' );
add_action( 'admin_menu', 'wix_admin_menu' );

function wix_admin_init() {
	/* スタイルシートを登録 */
	wp_register_style( 'wix-css', plugins_url('/css/wix-style.css', __FILE__) );
}

function wix_admin_settings_css() {
	wp_enqueue_style( 'wix-css', plugins_url('/css/wix-style.css', __FILE__), array() );
}

function wix_admin_menu() {

	add_menu_page(
		__('WIX Settings', 'wix-settings'),
		__('WIX Settings', 'wix-settings'),
		'administrator',
		'wix-admin-settings',
		'wix_admin_settings' 
	);

	add_action( 'admin_enqueue_scripts', 'wix_admin_settings_css' );

}

function wix_admin_settings(){
	?>
	<div class="wrap">
		<?php    echo '<h2>' . __( 'WIX PatternFile Options', 'wix_patternfile' ) . '</h2>'; ?>

		<?php
			if ( file_exists( PatternFile ) && is_readable( PatternFile ) ) {
				// var_dump( plugins_url('/css/wix-style.css', __FILE__) );
		?>
			<form id="patternFile_form" method="post" action="">
				<textarea id="patternFileContents">
					<?php
						$file = file_get_contents( PatternFile, FILE_USE_INCLUDE_PATH );
						echo $file;
					?>
				</textarea>
			</form>
		<?php
			} else {
				echo 'ないよ';
			}
		?>
	</div>

	<?php
}

?>