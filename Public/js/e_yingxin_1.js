$(function(){
	var Height = parseInt($(window).height());

	$("#background").css({
		width: $(document).width(),
		height: $(document).height()
	})

	$("#background>img").css({
		width: $(document).width(),
		height: $(document).height()
	})

	$("#title1").css({
		"margin-top": Height * 0.07 + 'px'
	})

	$("#content").css({
		"margin-top": Height * 0.12 + 'px'
	})

	$("#department").css({
		"margin-top": Height * 0.27 + 'px'
	})

	setInterval(function() {
		$("#background").css({
			width: $(document).width(),
			height: $(document).height()
		})

		$("#background>img").css({
			width: $(document).width(),
			height: $(document).height()
		})
	},100)

})
