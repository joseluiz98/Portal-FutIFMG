/**
* 
*/

/**
* put your comment there...
* 
* @type T_JS_FUNCTION
*/
(function($) {

	/**
	* 
	*/
	CJTBlockObjectPluginDockModule = new function() 
    {
		
		/**
		* 
		*/
		this.plug = function(block) 
        {
            
			// Define Dock method
			block.dock = function(elements, pixelsToRemove) 
            {
				// Initialize.
				var alwaysRemove = 33;
				pixelsToRemove = (pixelsToRemove != undefined) ? (pixelsToRemove + alwaysRemove) : alwaysRemove;
                
				// There're always 33 pixels need to be removed from the Code area
				var fixedHeight = this.block.box.height() - pixelsToRemove;
				var heightInPixels = fixedHeight + 'px';
                
				$(elements).css('height', heightInPixels);
                
                return fixedHeight;
			};
            
            // Responsive Helper
            block.responsiveDockHelper = new function()
            {

                
                /**
                * put your comment there...
                * 
                * @type Array
                */
                var insStack = [];
                
                /**
                * 
                */
                this.stackCallback = function()
                {
                    return insStack[insStack.length - 1].callback;
                };

                
                /**
                * 
                */
                this.stackNew = function(name, values)
                {
                    
                    var stackInstance = new Callback(values);
                    
                    insStack.push(stackInstance);
                    
                    return this;
                };
                
                /**
                * 
                */
                var Callback = function(values)
                {
                    
                    /**
                    * 
                    */
                    this.callback = function(item)
                    {
                        
                        var pixels;
                        
                        for(var widthOffset in values)
                        {
                            if (window.screen.width <= widthOffset)
                            {
                                
                                item.pixels += values[widthOffset];
                                
                                break;
                            }
                        }
                    
                    };
                };
                
                
            };
            
		};
		
	};
	
})(jQuery);