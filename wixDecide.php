<?php

// require_once( ABSPATH . 'wp-admin/includes/post.php' );


//Javascript→phpへのAjax通信を可能にするための変数定義
add_action("admin_head", 'ajaxURL');
function ajaxURL() {
	$str = "<script type=\"text/javascript\"> var ajaxurl = '%s' </script>";
	$ajaxurl = admin_url( 'admin-ajax.php' );
	printf($str, $ajaxurl);
}

add_action( 'wp_ajax_wix_decide_preview', 'wix_decide_preview' );
add_action( 'wp_ajax_nopriv_wix_decide_preview', 'wix_decide_preview' );

function wix_decide_preview() {
	header("Access-Control-Allow-Origin: *");
	header('Content-type: application/javascript; charset=utf-8');
    
 //    $json = array(
	// 		"blog" => $_GET['href'],
	// 		"author" => $_GET['target']
	// 	);
	// $callback = $_GET["callback"];
	// echo $callback."(" . json_encode($json) . ")";



	$post_ID = (int) substr( $_GET['target'], strlen('wp-preview-') );
	$_POST['ID'] = $post_ID;

	if ( ! $post = get_post( $post_ID ) ) {
		wp_die( __( 'You are not allowed to edit this post.' ) );
	}

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		wp_die( __( 'You are not allowed to edit this post.' ) );
	}



	$query_args = array( 'preview' => 'true' );
	$query_args['preview_id'] = $post->ID;
	// $query_args['preview_nonce'] = wp_create_nonce( 'post_preview_' . $post->ID );
	$query_args['post_format'] = empty( $_GET['post_format'] ) ? 'standard' : sanitize_key( $_GET['post_format'] );

	$url = add_query_arg( $query_args, urldecode(esc_url_raw(get_permalink( $post->ID ))) );

	$response = wp_remote_get( $url );

	if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
		
		$callback = $_GET["callback"];
		$response_body = wp_remote_retrieve_body( $response );
		$json = array(
			"response" => $url
		);
	    echo $callback."(" . json_encode($json) . ")";

	} else {

		var_dump( $response );

	}
	
    die();
}












$preview;
function nixcraft_preview_link($url, $post) {
    // $slug = basename(get_permalink());
    // $mydomain = 'http://server1.cyberciti.biz';
    // $mydir = '/faq/';
    // $mynewpurl = "$mydomain$mydir$slug&preview=true";
    // return "$mynewpurl";

    global $preview;
    $preview = $url;

    // var_dump($preview);
    // var_dump(get_permalink());

    return $url;
}
add_filter( 'preview_post_link', 'nixcraft_preview_link', 10, 2 );





	// if ( isset( $_GET['post'] ) )
	//  	$post_id = $post_ID = (int) $_GET['post'];
	// elseif ( isset( $_POST['post_ID'] ) )
	//  	$post_id = $post_ID = (int) $_POST['post_ID'];
	// else
	//  	$post_id = $post_ID = 0;

	// global $post;

	// var_dump($post_id);
	// var_dump($_GET['preview_nonce']);
	// var_dump( urldecode(get_permalink( $post->ID )) );





//post.phpでID取得
// if ( isset( $_GET['post'] ) )
//  	$post_id = $post_ID = (int) $_GET['post'];
// elseif ( isset( $_POST['post_ID'] ) )
//  	$post_id = $post_ID = (int) $_POST['post_ID'];
// else
//  	$post_id = $post_ID = 0;
// var_dump($post_id);










//強制リダイレクト
// add_action( 'publish_post', 'aaa', 99, 2 );
function aaa($post_ID, $post) {
    // die("test");
    wp_safe_redirect( 'http://localhost/wordpress/wp-admin/post.php?post=56&action=edit', 301 );
    exit;
}







//強制的に"下書き"にする
// add_filter( 'wp_insert_post_data' , 'filter_handler' , 10, 2 );
function filter_handler( $data , $postarr ) {
  $data['post_status'] = 'draft';
  return $data;
}



//postboxにメニュー追加
// add_action( 'post_submitbox_misc_actions', 'check_proofreading_button' );    
function check_proofreading_button() {  
    if(get_post_status() == 'publish') {  
        return;  
    }  
        $html  = '<div class="misc-pub-section" style="overflow:hidden">';  
        $html .= '<div id="publishing-action">';  
        $html .= '<input type="submit" tabindex="5" value="wixDecideからです" class="button-primary" id="proofreading" name="proofreading">';  
        $html .= '</div>';  
        $html .= '</div>';  
        echo $html;  
}  





//コンソールログに
add_action("admin_head", 'suffix2console');
function suffix2console() {
    global $hook_suffix;
    if (is_user_logged_in()) {
        $str = "<script type=\"text/javascript\">console.log('%s')</script>";
        printf($str, $hook_suffix);
    }   

	//フック名など
    // global $wp_filter;
    // foreach ($wp_filter as $key => $value) {
    // 	if ( $key == 'save_post' ) {
    // 		var_dump($key);
    // 		var_dump($wp_filter[$key]);
    // 	}
    // }
}

// hook_suffixが一致するページのみでmy_func()が実行される
add_action('admin_head-post.php', 'my_func');
function my_func(){
	$str = "<script type=\"text/javascript\">console.log('%s')</script>";
	printf($str, 'admin_head-hook_suffixです');
}




//transition_post_statusのテスト
// add_action( 'transition_post_status', 'post_unpublished', 99, 3 );
function post_unpublished( $new_status, $old_status, $post ) {
    if ( $old_status == 'publish'  &&  $new_status != 'publish' ) {
        // A function to perform actions when a post status changes from publish to any non-public status.
    	update_option( 'sauksa', 'aaa' );
    } else {
    	update_option( 'sakusa', $new_status.'<-'.$old_status );
    }
}
// var_dump( get_option( 'sakusa', 'default' ) );







//remove系のテスト
// remove_all_actions( 'save_post' );
// remove_action( 'transition_post_status', '_transition_post_status' );








// add_action('submitpost_box', 'hidden_fields');
// function hidden_fields(){
// 	// var_dump('ここにいるよ');
// }







// 公開する前にアラートを表示する
// add_action('admin_footer', 'publish_confirm', 10);

function publish_confirm() {

	$c_message = '記事を公開します。宜しいでしょうか？';

	$post_status = get_post_status( get_the_ID() ); 

	if ( $post_status == ('publish' || 'auto-draft') ) {

		echo '<script type="text/javascript"><!--
		var publish = document.getElementById("publish");
		if (publish !== null) publish.onclick = function(){
			
			if ( window.confirm("'.$c_message.'") ) {

			} else {
				alert(\'キャンセルされました\');
			}

			return confirm("'.$c_message.'");
		};
		// --></script>';

	}
	
}


?>