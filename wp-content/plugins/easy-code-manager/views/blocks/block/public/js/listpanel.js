/**
* 
*/

var CJTDropDownPanel;

/**
* 
*/
(function($)
{    
    
    $.fn.CJTDropDownPanel = function(_options)
    {
        
        /**
        * put your comment there...
        * 
        */
        var panelArgs = arguments;
        
        /**
        * put your comment there...
        * 
        * @param _options
        */
        var returns = this;
        
        // Panel Plugin
        this.each(
        
            function()
            {
                
                /**
                * put your comment there...
                * 
                */
                var jThis = $(this);
                
                /**
                * put your comment there...
                * 
                */
                var opts;
                
                /**
                * put your comment there...
                * 
                * @type T_JS_FUNCTION
                */
                var PlugFunctions = new function() 
                {

                    /**
                    * 
                    */
                    var hideOverlay = function()
                    {
                        
                        opts.overlay.hide();
                        opts.overlay.data('overlayyed', false);
                    };
                    
                    /**
                    * put your comment there...
                    * 
                    */
                    var showOverlay = function()
                    {
                        opts.overlay.show();
                        opts.overlay.data('overlayyed', true);
                    };
                    
                    /**
                    * Add panel item handler
                    * 
                    * @type T_JS_FUNCTION
                    */
                    this.addHandler = function(name, handler)
                    {
                        opts.handlers[name] = handler;
                    };
                    
                    /**
                    * 
                    */
                    this.disablePanel = function(panels)
                    {
                        
                        // Accept single or multiple items
                        if (typeof(panels) == 'string')
                        {
                            panels = [panels];
                        }
                        
                        // Disable panels
                        $.each(panels, 
                        
                            function(index, panelName)
                            {
                                if (opts.disabled.indexOf(panelName) == -1)
                                {
                                    
                                    // Add to disabled panels list cache
                                    opts.disabled.push(panelName);
                                    
                                    // Disable panel if its the current active panel
                                    if (panelName == PlugFunctions.getActivePanelName())
                                    {
                                        showOverlay();
                                    }
                                }                            
                            }

                        );


                    };
                    
                    /**
                    * put your comment there...
                    * 
                    * @param panelWnd
                    */
                    this.displayPanel = function(panelWnd)
                    {
                        
                        // First hide previously displayed panel
                        opts.display.find('.' + opts.panelGenericClass).hide();
                        
                        // Display Active panel
                        panelWnd.appendTo(opts.display).css('display', 'block');
                        
                        // Overlay if new displayed panel is disabled
                        if (opts.disabled.indexOf(PlugFunctions.getActivePanelName()) != -1)
                        {
                            if (!PlugFunctions.isOverlayyed())
                            {
                                showOverlay();
                            }
                        }
                        else
                        {
                            if (PlugFunctions.isOverlayyed())
                            {
                                hideOverlay();
                            }
                        }
                    }
                
                    /**
                    * 
                    */
                    this.enablePanel = function(panels)
                    {
                        
                        var panelDFlagIndex;
                        
                        // Accept single or multiple items
                        if (typeof(panels) == 'string')
                        {
                            panels = [panels];
                        }
                        
                        // Enable panels
                        $.each(panels, 
                            function(index, panelName)
                            {
                                
                                if ((panelDFlagIndex = opts.disabled.indexOf(panelName)) != -1)
                                {
                                    
                                    // Discard from disables list
                                    delete opts.disabled[panelDFlagIndex];
                                    
                                    // Remove overlay from panel if its the current enabled panel
                                    if (panelName == PlugFunctions.getActivePanelName())
                                    {
                                        hideOverlay();
                                    }

                                }
                        
                            }

                        );
                    };
                    
                    /**
                    * 
                    */
                    this.getActivePanelName = function()
                    {
                        
                        if (!PlugFunctions.isPanelOpened())
                        {
                            return false;
                        }
                        
                        return jThis.find('.cjt-panel-list-item.activePanel').eq(0).prop('href').match(/\#(.+)/)[1];
                    };
                    
                    /**
                    * 
                    */
                    this.getOpts = function()
                    {
                        return jThis.data('CJTDropDownPanel');
                    };
                    
                    /**
                    * 
                    */
                    this.getOverlay = function()
                    {
                        return opts.overlay;
                    };
                    
                    /**
                    * Get Panel Window Element ID From the panel name
                    * 
                    * @type T_JS_FUNCTION
                    */
                    this.getPanelElementClass = function(panelName)
                    {
                        return 'cjt-panel-window-' + panelName;
                    };                        
                    
                    /**
                    * 
                    */
                    this.getPanelWindow = function(panelClassName)
                    {
                        
                        var element;
                        
                        // Try to find panel window through first level scope
                        element = opts.panelsScope.find('.' + panelClassName);
                        
                        // If not then get it from second level scope
                        if (!element.length)
                        {
                            element = opts.l2PanelsScope.find('.' + panelClassName);
                        }
                        
                        return element;  
                    };
                    
                    /**
                    * 
                    */
                    this.inactivatePanels = function()
                    {
                        
                        // Current panel is selected
                        opts.display.removeClass('cjt-panels-list-current-' + PlugFunctions.getActivePanelName());
                        
                        // Active panel
                        $.each( opts.links, function() {$(this).removeClass('activePanel')});
                        
                        // Panel is closed
                        opts.display.removeClass('panelOpened');
                        
                    };
                    
                    /**
                    * 
                    */
                    this.isOverlayyed = function()
                    {
                        return opts.overlay.data('overlayyed');
                    };
                    
                    /**
                    * 
                    */
                    this.isPanelOpened = function()
                    {
                        return opts.display.hasClass('panelOpened');
                    };
                    
                    /**
                    * 
                    */
                    this.makeActive = function(panelName)
                    {
                        
                        var panelWnd = {};
                        
                        panelWnd.name = panelName;
                        panelWnd.className = this.getPanelElementClass(panelWnd.name);
                        
                        panelWnd.element = this.getPanelWindow(panelWnd.className);
                        
                        // Find Panel window as HTML element if no handle specified
                        if (opts.handlers[panelWnd.name] !== undefined)
                        {
                            
                            opts.handlers[panelWnd.name].callback.call(opts.context, panelWnd);
                            
                        }
                        
                        // Remove current panel class
                        if (this.isPanelOpened())
                        {
                            opts.display.removeClass('cjt-panels-list-current-' + this.getActivePanelName());
                        }
                        
                        // Add current panel class to display element
                        opts.display.addClass('cjt-panels-list-current-' + panelWnd.name);
                        
                        // Set title
                        opts.title.text(opts.links[panelWnd.name].text());
                        
                        // Mark as active panel
                        $.each(opts.links, function() {$(this).removeClass('activePanel' )});
                        opts.links[panelWnd.name].addClass('activePanel');
                        
                        // Display panel window
                        this.displayPanel(panelWnd.element);
                        
                        opts.display.addClass('panelOpened');
                        
                        // Switch panel event
                        jThis.trigger('SwitchPanel', [panelWnd]);
                        
                    };
                    
                    /**
                    * 
                    */
                    this.makeInactive = function(panelName)
                    {
                        
                        opts.links[panelName].removeClass('activePanel');
                        
                        opts.display.removeClass('cjt-panels-list-current-' + panelName);
                        
                        opts.display.removeClass('panelOpened');
                        
                    };
                    
                    /**
                    * 
                    */
                    this.setOpts = function(options)
                    {
                       jThis.data('CJTDropDownPanel', options); 
                    };

                    /**
                    * 
                    */
                    this.setPanelState = function(panels, state)
                    {
                        
                        if (state == true)
                        {
                            PlugFunctions.enablePanel(panels);
                        }
                        else
                        {
                            PlugFunctions.disablePanel(panels);
                        }
                        
                    };
                    
                };
                    
                // Method calls
                if (typeof(_options) == 'string')
                {
                    
                    // UI implementation
                    opts = PlugFunctions.getOpts();
                
                    // Call method
                    var panelArgsArr = [];
                    
                    for (var panelArgIdx = 1; panelArgIdx < panelArgs.length; panelArgIdx++)
                    {
                        panelArgsArr.push(panelArgs[panelArgIdx]);
                    }
                    
                    // Dispatch method
                    var callReturns = PlugFunctions[panelArgs[0]].apply(this, panelArgsArr);
                    
                    // Returns only if value returned
                    if (callReturns !== undefined)
                    {
                        returns = callReturns;
                    }
                    
                    return;
                }
                
                // Constructor //
                var defaultOptions = 
                { 
                    disabled : [],
                    display : null,
                    overlay : null,
                    closeLinkSelector : '.close-panel',
                    closePanelHandler : null,
                    l2PanelsScope : $('body'), 
                    panelsScope : $('body'), 
                    titleElementSelector : '.panel-title',
                    panelGenericClass : '',
                    handlers : {},
                    links : {}
                };
                
                // Store options
                _options = $.extend(defaultOptions, _options);
                PlugFunctions.setOpts(_options);
                
                // Read options for events below to find options
                opts = _options;
                
                // Overlay element
                if (opts.overlay === null)
                {
                    opts.overlay = $('<div class="cjt-panel-overlay"></div>');
                }
                opts.overlay.appendTo(opts.display);
                
                // Close link
                opts.display.find(opts.closeLinkSelector)
                
                .click(
                
                    function()
                    {
                        
                        opts.closePanelHandler();
                        
                        return false;
                    }
                );
                
                // bind events
                for (var optName in opts) 
                {
                    
                    // Event are those start with "on" and has callback function defined
                    if ((optName.indexOf('on') == 0) && $.isFunction(opts[optName]))
                    {
                        jThis.bind(optName.substring(2), opts[optName]);
                    }
                    
                }
                
                // Find Panel elements
                opts.title = opts.display.find(opts.titleElementSelector);
                
                // Active Panel
                if (opts.activePanel)
                {
                    PlugFunctions.makeActive(opts.activePanel);    
                }
                
                // Display panel window when panel link is clicked
                jThis.find('.cjt-panel-list-item').unbind('click').bind('click',
                
                    function(event)
                    {
                        
                        var jLink = $(event.target);
                        var cInfo = 
                        {
                            cancel : false,
                            isActive : jLink.hasClass('activePanel')
                        };
                        
                        jThis.trigger('PanelClick', [cInfo, opts, PlugFunctions]);
                        
                        // Display panel / Make active
                        var panelName = event.target.href.match(/\#(.+)/)[1];
                        
                        if (cInfo.cancel)
                        {
                            PlugFunctions.makeInactive(panelName);
                        }
                        else
                        {
                            PlugFunctions.makeActive(panelName);
                        }
                        
                        return false;
                    }
                
                )
                
                // Hold reference to all panel links
                .each( 
                
                    function(idx, panelLink)
                    {
                        
                        var jPanelLink = $(panelLink);
                        
                        opts.links[jPanelLink.prop('href').match(/\#(.+)/)[1]] = jPanelLink;
                    }
                    
                );
                
            }
        
        );
        
        return returns;
    };
    
})( jQuery );