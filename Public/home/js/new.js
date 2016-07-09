$(document).ready(function() {
	var t;

	function showTip(tip) {
		$('.tip').hide();
		clearTimeout(t);
		if (tip.is(':hidden')) {
			tip.show();
			t = setTimeout(function() {
				tip.hide();
			}, 2000);
		}
	}

	function scrollTowhere(which) {
		$('body').animate({
			scrollTop: which.position().top - 200
		}, 300);
		which.focus();
	}

	// 验证表单
	$('#submit').click(function(theme,content) {
		var theme = $('#theme'),
			content = $('#content'),
			tip = null;

		// 标题空白
		if ((theme.val() === "") || (theme.val().match(/^\s*$/))) {
			scrollTowhere(theme);
			tip = $('#tips-theme');
			// 内容空白
		} else if ((content.val() === "") || content.val().match(/^\s*$/)) {
			scrollTowhere(content);
			tip = $('#tips-content');
			// 主题长度
		} else if (theme.val().length > 60) {
			scrollTowhere(theme);
			tip = $('#tips-theme-length');
			//内容长度
		} else if (content.val().length > 1000) {
			scrollTowhere(content);
			tip = $('#tips-content-length');
		}
		if (tip) {
			showTip(tip);
			return false;
		}
	});

	// 节点选择
	$('#node-button').click(function(e) {
		var node = e.target.textContent;

		$("#node option").each(function() {
			$(this).attr("selected", false);
			if ($(this).text() === node) {
				$(this).attr("selected", true);
				return false;
			}
		});
	});



});