jQuery(document).ready(function($) {
	
	// Post archive sidebar nested links
	$('.post-archive li, .post-archive ul.month').hide();
	$('.post-archive .current').show();
	$('.post-archive .current').parent('li').show();
	$('.post-archive ul.month.current').find('li').show();
	$('.post-archive li span.year-click').bind('click', function() {
		$(this).parent().find('li').toggle();
	});
	$('.post-archive ul span.month-click').bind('click', function() {
		$(this).parent().find('li').toggle();
	});
	
	// Syntax highlighting
	$('pre:not(.debug) code').each(function()
	{
		$(this).addClass('brush: php, class-name: highlighted');
	});
	SyntaxHighlighter.config.tagName = 'code';
	SyntaxHighlighter.defaults.gutter = true;
	SyntaxHighlighter.all();
	
});