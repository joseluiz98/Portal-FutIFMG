/**
*
*/

/**
*
*
*
*/
(function($) 
{
            	
	// Wait form to be loaded.
	$( 
    
        function()
        {
            
            var block = window.parent.CJTBlocksPage.blocks.getBlock( $( 'input:hidden#blockId' ).val() ).get( 0 ).CJTBlock;
            
            // Apply block theme colors
            $('body').css(
            {
                'color' : block.theme.color,
                'background-color' : block.theme.link.bgColor
            });
            
            $('body *').css(
            {
                'border-color' : block.theme.link.color,
            });
            
            $('a.copyshortcode button').css(
            {
                'background-color' : block.theme.link.bgColor,
                'color' : block.theme.color,
            });
            
            // Button hover CSS
            var css = 'a.copyshortcode button:hover{color : ' + block.theme.link.hover + '};';
            
            // Append style
            var styleEle = $('#info-style');
            
            styleEle .text(styleEle.text() + css);
            
            block.trigger('InfoPanelLoaded');
        }
    
    );
	
} ) ( jQuery );