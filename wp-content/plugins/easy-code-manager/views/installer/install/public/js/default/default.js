/**
* 
*/

/**
* 
*/
(function($) {
	
	/**
	* 
	*/
	var CJTInstallerForm = {

		/**
		* put your comment there...
		* 
		*/
		installationForm : null,
		
		/**
		* Start installation process.
		* 
		* @return void
		*/
		_oninstall : function() 
        {
            
			var operations = [];
            
			// Operations to process.
			this.installationForm.find('ul.installation-list').each($.proxy(
            
				function(listIndex, list) 
                {
					var typeName = list.className.split(' ').pop();
                    
					$(list).find('li').each($.proxy(
                    
						function(index, li)
                        {
                            

                            var oli = $(li);
                            
							// All operation with no installed class are included
							if (oli.find('input:checkbox').prop('checked') && !oli.hasClass('installed'))
                            {
								// Add to operations list!
								operations.push(
                                    {
                                        type : typeName,
                                        name : li.className.split(' ')[0]
                                    }
                                );
							}
                            
						}, this)
					);
				}, this)
			);
			// Create installer object!
			var installer = new CJTInstaller(operations);
            
			// Disable form to disallow repeating actions!
			this.installationForm.find('input').prop('disabled', 'disabled');
            
			//For each operation progress the installation!
			installer.install($.proxy(
            
				function(promise, operationId, operation) 
                {
                    
					// Get li node from operation details.
					var li = this.installationForm.find('ul.installation-list.' + operation.type + ' li.' + operation.name);
                    
					// Show loading progress and hide checkbox.
					li  .removeClass('fail')
                        .removeClass('installed')
                        .addClass('progress')
                        
                        .find('input:checkbox').hide();
                    
					// We need to know when operation faild or success.
					promise.done($.proxy( // Operation installation successed.
                    
						function() 
                        {
                            
							// Mark as installed!
							li.addClass('installed').prop('title', '');
                            
						}, this)
                        
					).fail($.proxy( // Operation installation faild!
                    
						function(errorMsg) 
                        {
                            
							alert(CJTInstallerDefaultI18N.operation_fails_msg.replace('%err_msg%', errorMsg));
                            
                            li.addClass('fail').prop('title', errorMsg);
                            
						}, this)         
                        
					).always($.proxy(
                    
					  function() 
                      {
                          
                            li.removeClass('progress')
                            
					  }, this)
                      
					);
                    
					// Always do the operation!
					return true;
                    
				}, this)
                
			).always($.proxy( // Overall installation completed with error!
            
                function() 
                {
                    
                    // Enable form to accept other actions!
                    this.installationForm.find('input:button').prop('disabled', '');
                    
                }, this)
                
            ).done($.proxy( // Overall installation completed with success!
            
				function() 
                {
                    // Show success message!
                    tb_show(
                        CJTInstallerDefaultI18N.successDialogTitle,
                        'TB_inline?inlineId=installer-success-dialog-holder&width=400&height=60'
                    );
                    
					// Setup START button!
					this.installationForm.find('input:button')
                    
					// Change button caption to done!
					.val(CJTInstallerDefaultI18N.startButtonText)
					// Unbind uninstall method!
					.unbind('click', this._oninstall)
					// Bind to start method.
					.bind('click', this._onstart);
                    
				}, this)
                
			);
            
            return false;
		},
		
		/**
		* 
		*/
		_onstart : function() {
			// Just refresh window and server will do the rest!
			window.location.reload();
		},
		
		/**
		* put your comment there...
		* 
		*/
		init : function() 
        {
            
			this.installationForm = $('form[name="installation-form"]');
            
			this.installationForm.find('input:button, a[href$="install"]').click($.proxy(this._oninstall, this));

		}

	} // End CJTInstallerform.
	
	// Initioalize form when document ready!
	$($.proxy(CJTInstallerForm.init, CJTInstallerForm));
		
})(jQuery);