/**
* 
*/

/**
* 
*/
(function($)
{
    
    /**
    * 
    */
    var ECMCJTChecker = new function()
    {
        
        /***
        * put your comment there...
        * 
        * @param event
        */
        var _OnMigrate = function(event)
        {
            
            var nonce = $('input:hidden[name="ecm-cjtchecker-notice-nonce"]').val();
            
            $.post(
                ajaxurl,
                {
                    action : 'ecm-migrate-cjt',
                    nonce : nonce
                }
            ).done(
                
                function(errorMsg)
                {
                    if (errorMsg)
                    {
                        alert(errorMsg);
                    }
                    else
                    {
                        $('#ecm-migrate-cjt-success-message').dialog(
                            {
                                title : 'Advanced Data Migration Complete …',
                                width : 500,
                                height : 200
                            }
                        );
                    }
                }
            )
            
            return false;
        };
        
        /**
        * put your comment there...
        * 
        */
        var init = function()
        {
            $('a[href$="migrate"]').click(_OnMigrate);
            
            $('#ecm-migrate-cjt-success-message button').click(
                
                function()
                {
                    
                    $('#ecm-migrate-cjt-success-message').dialog('close');
                    
                    return false;
                }
            )
        }
        
        $(init);
    };
    
})(jQuery);