$(function() {
	var $t, leftX, newWidth;

	$('.js-navbar-menu').append('<div class="block"></div>');
	var $block = $('.block');

	$block.width($(".navon").width()).css('left', $('.current a').position().left).data('rightLeft', $block.position().left).data('rightWidth', $block.width());

	$('.js-navbar-menu li').find('a').hover(function() {
		$t = $(this);
		leftX = $t.position().left;
		newWidth = $t.parent().width();

		$block.stop().animate({
			left: leftX,
			width: newWidth
		},300);
	}, function() {
		$block.stop().animate({
			left: $block.data('rightLeft'),
			width: $block.data('rightWidth')
		},300)
	})
	// $($('.menu ul li.current'))[0].setAttribute('id','firstLi');
	// var getClass = $($('.menu ul li.current'))[0].getAttribute('class','current');
	// console.log(getClass)
})