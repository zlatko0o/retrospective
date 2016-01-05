(function ($) {

	$.fn.panel = function(settings)
	{
		function load()
		{

		}

		function buildHtml( title, iconClass, content )
		{
			return $( '<div></div>' ).append(
				$( '<div></div>' ).append(
					$( '<span></span>' ).text( title ),
					$( '<i></i>' ).addClass( 'fa' ).addClass( iconClass ).addClass( 'fa-fw' )
				).addClass( 'panel-heading' ),
				$( '<div></div>' ).html( content ).addClass( 'panel-body' )
			).addClass( 'panel' ).addClass( 'panel-default' );
		}
	}

})(jQuery);