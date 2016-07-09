$(document).ready(function() {
	var now = new Date();
	console.time("each");

	function getTime() {
		var old = new Date($(this).text().replace(/-/g,'/')),	//Firefox时间格式要求
			dif = now - old,
			day = Math.floor(dif / (24 * 3600 * 1000)),
			hour = Math.floor(dif / (3600 * 1000)),
			min = Math.floor(dif / (60 * 1000)),
			second = Math.floor(dif / (1000)),

			nowYear = now.getFullYear(),
			oldYear = old.getFullYear(),
			nowMonth = now.getMonth(),
			oldMonth = old.getMonth();

		if (second < 60) {
			$(this).text(second + " 秒前");
		} else if (min < 60) {
			$(this).text(min + ' 分钟前');
		} else if (hour < 24) {
			$(this).text(hour + ' 小时 ' + (min - hour * 60) + ' 分钟前');
		} else if (day < 32) {
			$(this).text(day + ' 天前');
		} else if (day < 366) {
			if (nowYear === oldYear) {
				$(this).text(nowMonth - oldMonth + ' 个月前');
			} else {
				$(this).text(nowMonth - oldMonth + 12 + ' 个月前')
			}
		} else {
			$(this).text(now.getFullYear() - old.getFullYear() + " 年前");

		}
		$(this).show();
	}

	$('.time').each(getTime);
	$('.header-time').each(getTime);

	$('.reply-info').each(function() {
		$(this).mouseover(function() {
			$(this).find('.thank-area').show();
		});
		$(this).mouseout(function() {
			$(this).find('.thank-area').hide();
		});
	});
	console.timeEnd("each");
});
