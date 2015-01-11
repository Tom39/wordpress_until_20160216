jQuery(function($) {

//パターンファイルのフォーム追加
$('#add_patternFile').click(function() {
	var parentElementName = '#patternFile_form #pattern_wid ';

	//フォームを追加
	var pattern_wid_len = $(parentElementName + 'li').length;
	var insertElement = '<li><input type="text" name="pattern[' + pattern_wid_len + ']"> <input type="text" name="wid[' + pattern_wid_len + ']"></li>';
	$(parentElementName).append(insertElement);

	// 削除ボタンの一旦全消去し、配置し直す
	$(parentElementName + 'input[type="button"]').remove();

	var delete_btn = ' <input type="button" value="Delete" class="button button-primary button-large">';
	$(parentElementName + 'li').each(function(index) {
		$(parentElementName + 'li').eq(index).append(delete_btn);
	});


});

// 削除ボタンを押した場合の処理
$(document).on('click', '#patternFile_form #pattern_wid input[type="button"]', function(e) {
	var parentElementName = '#patternFile_form #pattern_wid ';

	//フォームを削除
	var idx = $(e.target).parent().index();
	$('#patternFile_form #pattern_wid li').eq(idx).remove();

	// フォームがひとつになるなら、削除ボタンは不要なので消去
	if ($(parentElementName + 'li').length == 1) $(parentElementName + 'input[type="button"]').remove();

	// フォームの番号を振り直す
	$(parentElementName + 'li').each(function(index) {
		 $(this).children('input:text:eq(0)').attr('name', 'pattern[' + index + ']');
		 $(this).children('input:text:eq(1)').attr('name', 'wid[' + index + ']');
	});

});







});


// window.document.getElementById('add_patternFile').addEventListener('click', addForms, false);

// $(function() {
// 	$('#add_patternFile').click( addForms() );
// });

// $('#add_patternFIle').click( addForms() );

// function addForms() {
// 	alert('ばも');
// }
