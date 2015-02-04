jQuery(function($) {

	if ( $('#submitdiv').length ) {
	    stamp = $('#timestamp').html();
	    $('#timestampdiv')
	      .before('<p><a class="update-timestamp hide-if-no-js button" href="#update_timestamp">最新の日時に置き換えます</a></p>')
	      .prev().click(function(){
		        date = new Date();
		        var aa = date.getFullYear(), mm = date.getMonth() + 1, jj = date.getDate(), hh = date.getHours(), mn = date.getMinutes();
		        mm = '' + mm;
		        if(mm.length == 1) mm = '0' + mm;
		        $('#aa').val(aa);
		        $('#mm').val(mm);
		        $('#jj').val(jj);
		        $('#hh').val(hh);
		        $('#mn').val(mn);
		        $('#timestamp').html(
		        	postL10n.publishOnPast + ' <b>' +
		        	aa + '年' +
		        	mm + '月' +
		        	jj + '日 @ ' +
		        	hh + ':' +
		        	mn + '</b> '
		        );

				return false;
	      });
  	}

  	//リダイレクト
		// $(location).attr("href", "http://localhost/wordpress/wp-admin/post.php?post=56&action=edit");


	if ( $('#publish').length ) {
		// $('#publish').hide();		

		$('#publish')
			.before('<input name="wix" type="button" class="button button-primary button-large" id="wix" value="佐草" >')
			.prev().click(function(evt) {

				var href = $('#post-preview').attr('href');
				var target = $('#post-preview').attr('target');
				var post_format = $('#post-formats-select :input:checked').val();
				var ifr_body = $('iframe:first').contents().find('#tinymce').eq(0).html();

				var data = {
					'action': 'wix_decide_preview',
					'href' : href,
					'target' : target,
					'post_format' : post_format
				};

				$.ajax({
					dataType:"jsonp",
					type: "GET",
					url: ajaxurl,
					data: data,
					jsonpCallback: 'callback',
					success: function(response) {
						var pop;
						// html、bodyの固定
                		// $('html body').addClass('lock');


						$.each(response, function(key,value){
							// alert(key + 'は、' + value);
							
							pop = new $pop(value , {
								type: 'iframe',
								title: 'WIX Manual Decide',
								width: 1100,
								height: 650,
								modal: true,
								windowmode: false,
								close: true,
								resize: true
							});  

                		});


                		$('#pwCover').off().click(function(event) {
                			// html、bodyの固定解除
			                // $('html, body').removeClass('lock');

                			pop.close();
                		});

					},

					error: function(xhr, textStatus, errorThrown){
      					alert('Error');
    				}
				});
			
			return false;

			});

	} else {
		// alert('elseだよ');
	}





});

