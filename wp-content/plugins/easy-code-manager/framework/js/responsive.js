
/**
* 
*/
(function($)
{
    
    /**
    * put your comment there...
    * 
    */
    window.CJTResponsiveHelper = new function()
    {        
        /**
        * put your comment there...
        * 
        * @type Object
        */
        var widthsMap = {};
        
        /**
        * put your comment there...
        * 
        */
        var cssMarker = function()
        {
            
            var body = $('body');
            
            $.each(widthsMap,
            
                function(index, width)
                {
                    
                    var widthBodyClass = 'cjt-responsive-wm-' + width;
                    
                    if ((screen.width <= width))
                    {
                        
                        if (!body.hasClass(widthBodyClass))
                        {
                            body.addClass(widthBodyClass);    
                        }
                        
                    }
                    else
                    {
                        
                        if (body.hasClass(widthBodyClass))
                        {
                            body.removeClass(widthBodyClass);    
                        }
                        
                    }
                }
            
            );
        };
        
        /**
        * 
        */
        this.defWidths = function(map)
        {
            
            widthsMap = map;
            
            return this;
        };
        
        // Init when ready
        $($.proxy(
            
            function()
            {
                // Set Default widths map
                this.defWidths([786]);
                
                // Init for first time
                cssMarker();
                
                // Set responsive class names when window resized
                $(window).resize($.proxy(cssMarker));                
            }
        
        , this));

        /**
        * 
        */
        this.getThickBoxSize = function(params, recusriveLevel)
        {
            
            var wnd = $(window);
            
            if (recusriveLevel === undefined)
            {
                recusriveLevel = 0;
            }
            
            var stopOffset = 
            {
                width : params.width + 30,
                height : params.height + 60 + (recusriveLevel * 20)
            };
            
            // Landscape on low screen height need less height dialogs
            if (wnd.height() < wnd.width())
            {
                stopOffset.height += 50
            }
            
            // Calculate width and height based on window size
            // Get smaller when window is smaller and vise versa
            
            params.width += ((wnd.width() < stopOffset.width) ?  (wnd.width() - stopOffset.width) : 0);
            params.height += ((wnd.height() < stopOffset.height) ?  (wnd.height() - stopOffset.height) : 0);
            
            return params;
        };
        
    };
    
})(jQuery);