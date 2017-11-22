/**
* 
*/

/**
* 
*/
(function($) {
	
	/**
	* Override CJTBlockPlugin class.
	* 
	* @param node
	* @param args
	*/
	CJTBlockPlugin = function(node, args) {			
		
		/**
		* 
		*/
		this.pagesPanel = null;
		
        /**
        * put your comment there...
        * 
        */
        var _onchangestate = function(event, block, state)
        {
            
            var elements = block.block.box.find('.cjt-panel-window-assignment-panel input:checkbox, .cjt-panel-window-assignment-panel textarea, .cjt-panel-window-assignment-panel select');
            
            if (state == true)
            {
                elements.removeAttr('disabled');
            }
            else
            {
                elements.attr('disabled', 'disabled');
            }
        };
        
		/**
		* put your comment there...
		* 
		*/
		var _onload = function() 
        {

			// Plug the assigment panel, get the jQuery ELement for it
			var assigmentPanelElement = this.block.box.find('#tabs-' + this.block.get('id'));
            var shrinkFactor = -27;
            var advTabShkringFactor = 15;
            
			this.pagesPanel = assigmentPanelElement.CJTBlockAssignmentPanel({block : this}).get(0).CJTBlockAssignmentPanel;
            
            this.responsiveDockHelper.stackNew('assignmentPanel', {
                395 : 70, 
                518 : 50,
                768 : 3, 
                850 : 38, 
                955 : 3
            });
            
			// More to Dock with Fullscreen mode!
			var extraDocks = [
            
                {
                    element : assigmentPanelElement.find('.ui-tabs-panel'), 
                    eCallback : this.responsiveDockHelper.stackCallback(),
                    pixels : 92 + shrinkFactor
                },
                
				{
                    element : assigmentPanelElement.find('.ui-tabs-panel .pagelist'),
                    eCallback : this.responsiveDockHelper.stackCallback(),
                    pixels : 146 + shrinkFactor
                },
				
				{
                    element : assigmentPanelElement.find('.custom-posts-container'),
                    eCallback : this.responsiveDockHelper.stackCallback(),
                    pixels : 145 + shrinkFactor
                },
                
				{
                    element : assigmentPanelElement.find('.custom-posts-container .custom-post-list'),
                    eCallback : this.responsiveDockHelper.stackCallback(),
                    pixels : 170 + shrinkFactor
                },
                
				{
                    element : assigmentPanelElement.find('.custom-posts-container .custom-post-list .pagelist'),
                    eCallback : this.responsiveDockHelper.stackCallback(),
                    pixels : 182 + shrinkFactor
                },
				
				{
                    element : assigmentPanelElement.find('.advanced-accordion .ui-accordion-content'),
                    eCallback : this.responsiveDockHelper.stackCallback(),
                    pixels : 198 + shrinkFactor + advTabShkringFactor
                },
                
				{
                    element : assigmentPanelElement.find('.advanced-accordion .ui-accordion-content textarea'),
                    eCallback : this.responsiveDockHelper.stackCallback(),
                    pixels : 206 + shrinkFactor + advTabShkringFactor
                }
                
			];
			
            $.each(extraDocks, $.proxy(
            
                function(index, dockItem)
                {
                    
                    this.extraDocks.push(dockItem);
                    
                } ,this) 
            );
            // Apply theme
            this.bind('themechanged', 
            
                function(event, block, theme)
                {
                    

                }
            );
            
            // Assignment panel loaded event
			this.block.box.trigger( 'cjtassignableblockloaded', [ this ] );
            
            this.bind('ChangeState', _onchangestate);
		};
		
		// Load block only when loaded by parent model.
		this.onLoad = _onload;
        
		/// Initialize parent class.
		// Add assigment panel fields to the restoreRevision args.
		args.restoreRevision = {fields : ['code', 'pages', 'posts', 'categories', 'pinPoint', 'links', 'expressions']};
		
		this.initCJTPluginBase(node, args);
		
	} // End class.
	
	// Extend CJTBLockPluginBase.
	CJTBlockPlugin.prototype = new CJTBlockPluginBase();
})(jQuery);