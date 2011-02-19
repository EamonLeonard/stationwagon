function filterArticles(show)
{
	$('#articles').html('');
    $('#loading').html('Loading');

	$('#articles').fadeOut('slow', function()
    {
		$('#articles').load('articles/index/'+show+' #articles');
		$('#loading').fadeOut('slow', function()
        {
			$('#articles').fadeIn('slow');
		});

	});
}