/**
* @version $ Id; block.jquery.js 21-03-2012 03:22:10 Ahmed Said $
* 
* CJT Block jQuery Plugin
*/

/**
* JQuery wrapper for the CJTBlockPlugin object. 
*/
(function($) {

	/**
	* 
	*/
	var notifySaveChangesProto = function(block) {
		
		/**
		* put your comment there...
		* 
		* @param block
		*/
		this.initDIFields = function() 
        {
			// Initialize notification saqve change singlton object.
			block.changes = [];
			// Initialize vars.
			var model = block.block;
			var aceEditor = model.aceEditor;
			var fields = model.getDIFields();
            
			// Create common interface for ace editor to
			// be accessed like other HTML elements.
			aceEditor.type = 'aceEditor'; // Required for _oncontentchanged to behave correctly.
			aceEditor.bind = function(e, h) 
            {
				this.getSession().doc.on(e, h);
			}
			aceEditor.cjtSyncInputField = function() 
            {
				this.cjtBlockSyncValue = hex_md5(this.getSession().getValue());	
			}
            
			// Hack jQuery Object by pushing
			// ace Editor into fields list, increase length by 1.
			fields[fields.length++] = aceEditor;
            
			// For all fields call cjtSyncInputField and give a unique id.
			$.each(fields, $.proxy(
            
				function(index, field) 
                {
					this.initElement(field);
                    
				}, this)
                
			);
			// Chaining.
			return this;
		},
		
		/**
		* put your comment there...
		* 
		* @param element
		*/
		this.initElement = function(field) 
        {
            
            var changeEvent = 'change';
            
            var defaultSyncFunc = function() 
            {
                  this.cjtBlockSyncValue = this.value;
            };
            
            var chkboxSyncFunc = function() 
            {
                  this.cjtBlockSyncValue = $(this).prop('checked');
            };
                        
			// Assign weight number used to identify the field.
			field.cjtBlockFieldId = CJTBlocksPage.blocks.getUFI();
            
			// Create default cjtSyncInputField method if not exists.
			if (field.cjtSyncInputField == undefined) 
            {
                
                switch (field.type)
                {
                    
                    case 'checkbox':
                    
                        field.cjtSyncInputField = chkboxSyncFunc;
                        
                    break;

                    case 'text':
                    case 'textarea':
                    
                        changeEvent = 'input';
                        
                    default:
                        
                        field.cjtSyncInputField = defaultSyncFunc;
                        
                    break;
                }
                                
				// Create interface to "bind" too.
				field.bind = function(e, h) 
                {
			  	    $(this).bind(e, h);
				}
			}
			// Sync field.
			field.cjtSyncInputField();
            
			// Bind to change event.
			field.bind(changeEvent, $.proxy(block._oncontentchanged, block));
		}
	};

	/**
	* Default block features and options.
	*
	* @var object
	*/
	var defaultOptions = {
		showObjectsPanel : true,
		calculatePinPoint : 1,
		restoreRevision : {fields : ['code']}
	};

	/**
	* Element to loads for each block.
	*
	* This element is commonly used in various places inside the Plugin.
	* there is no need to find them everytime we need it. Load it only one time.
	* 
	* @var object
	*/	
	var autoLoadElements = 
    {
		insideMetabox : 'div.inside'
	};

	/**
	* Block jQuery Plugin.
	*
	* The purpose is to handle all block functionality and UI.
	*
	* @version 6
	* @Author Ahmed Said
	*/
	CJTBlockPluginBase = function() {
		
        /**
        * put your comment there...
        * 
        * @type String
        */
        var eventNamePrefix = 'cjtblock';
        
		/**
		* Block model for accessing block properties.
		*
		* @var CJTBlock
		*/
		this.block;
		
		/**
		*
		*
		*/
		this.changes;
		
		/**
		* 
		*/
		this.defaultDocks;
		
		/**
		* Commonly accessed elements stored here.
		*
		* @var object
		*/
		this.elements;
		
		/**
		* 
		*/
		this.extraDocks = [];
        
		/**
		* Block features and options.
		*
		* @var object
		*/			
		this.features;
		
		/**
		* 
		*/
		this.internalChanging = false;
		
        /**
        * 
        */
        this.twoRowWidth = 768;
        
		// Block Plugins
		CJTBlockObjectPluginDockModule.plug(this);
		
		/**
		*
		*
		*/
		this._oncontentchanged = function(event) 
        {
			// Dont process internal changes.
			if (this.internalChanging) 
            {
				return;
			}
            
			
			var element;
			var id;                 // Give every field an id for tracing change.
			var newValue;           // Field new value.
			var enable;             // Used to enable/disable save button                                                             
									// based on detected changes.
			var isFieldChanged;
			var isChanged;
			var syncValue; // This is the value stored in server.
            
			// Get value, id and sync value based on the input field type.
			if (event.target == undefined) 
            {   
                
				element = this.block.aceEditor;
                
				// pass aceEditor object as context!
				newValue = hex_md5(element.getSession().getValue());
			}
			else 
            { 
                
				element = event.target;
				// Use field "value" property for getting new 
				// context except checkboxes uses checked property.
				newValue = (element.type == 'checkbox') ? newValue = $(element).prop('checked') : element.value;
			}
            
			id = element.cjtBlockFieldId;
			syncValue = element.cjtBlockSyncValue;
            
			// Detect if value is changes.
			isFieldChanged = (newValue != syncValue);
			isChanged = CJTBlocksPage.blocks.calculateChanges(this.changes, id, isFieldChanged);
            
			// Enable button is there is a change not saved yet, disable it if not.
			this.manageToolbox.buttons.save.enable(isChanged);
            this.manageToolbox.buttons.save.flash(isChanged, true);
            
			// Notify blocks page.
			CJTBlocksPage.blockContentChanged(this.block.id, isChanged);
		}
		
		/**
		* Event handler for delete the block.
		*
		* The method delete the block from the UI but not permenant from the server.
		* Save all Changes should be called in order to save deleted blocks.
		*/
		this._ondelete = function() 
        {
            
			// Conformation message.
			var confirmMessage = CJTJqueryBlockI18N.confirmDelete;
			confirmMessage = confirmMessage.replace('%s', this.block.get('name'));
            
            // Before delete event
            this.trigger('Deleting');
            
			if (confirm(confirmMessage)) 
            {
                
                // Block Panel Delete Notification
                if (this.panel !== undefined)
                {

                    this.panel.CJTDropDownPanel('inactivatePanels');    
                    
                    CJTBlocksPage.blocksForm.data( 'activePanelBlock', null );
                }
                
				// Delete block.
			  	CJTBlocksPage.deleteBlocks(this.block.box);
                
                // Deleting block event for cleanup process
                this.trigger('Deleted');
                
                return;
			}
            
            // Deleting block event for cleanup process
            this.trigger('DeleteAbort');
            
		}

        /**
        * 
        */
		this._ongetinfo = function( panelWnd )
        {
            
			var url = CJTBlocksPage.server.getRequestURL('block', 'get_info_view', {id : this.block.get('id')});
            
            panelWnd.element.prop('src', url);
            
		};
		
		/**
		* Don't show popup menus if Block is minimized!
		*/
		this._onpopupmenu = function(targetElement, button) 
        {
			var show = true;
			if (this.block.box.hasClass('closed')) 
            {
				show = false;
			}
			else 
            {
				// Some Popup forms need to be re-sized if fullscree is On!
				if (button.params.fitToScreen == true) 
                {
					this.dock(targetElement, 25);
				}
			}
			return show;
		}
		
		/**
		* 
		*/
		this._onpostboxopened = function() 
        {
			// If aceEditor is undefined then the 
			// block is no loaded yet,
			// loads it.
			if (this.block.aceEditor == undefined) 
            {
				this._onload();
			}
			else 
            {
				// Update ACE Editor region.
				this.block.aceEditor.resize();
			}
		};
        
		/**
		* Event handler for saving block data.
		*
		* The method send the block data to the server.
		* @see CJTBlock.saveDIFields method for more details about fields.
		*
		*/
		this._onsavechanges = function() 
        {
            
			var saveButton = this.manageToolbox.buttons['save'];
            
			// Dont save unless there is a change!
			if (saveButton.jButton.hasClass('cjttbs-disabled')) 
            {
				// Return REsolved Dummy Object for standarizing sake!
				return CJTBlocksPage.server.getDeferredObject().resolve().promise();
			}
            
			// Queue User Direct Interact fields (code, etc...).
			var data = {calculatePinPoint : this.features.calculatePinPoint, createRevision : 1};
            
			// Push DiFields inside Ajax queue.
			this.block.queueDIFields();
            
			// Add code file flags to the queue.
			var queue = this.block.getOperationQueue('saveDIFields');
			queue.add(
                {
                    id : this.block.get('id'),
                    property : 'activeFileId',
                    value : this.codeFile.file.activeFileId
                }
            );
            
			// But save button into load state (Inactive and Showing loading icon).
			this.enable(false);
            saveButton.flash(false);
            
			// Send request to server.
			return this.block.sync('saveDIFields', data).success($.proxy(
            
				function() 
                {

					// Sync fields with server value.
					// This refrssh required for notifying saving
					// change to detect changes.
					var diFields = this.block.getDIFields();
                    
					// Push aceEditor into diFields list.
					diFields[diFields.length++] = this.block.aceEditor;
					diFields.each
                    (
						function() 
                        {
							this.cjtSyncInputField();
						}
					);
                    
					// Reset changes list.
					this.changes = [];
                    
					// Tell blocks page that block is saved and has not changed yet.
					CJTBlocksPage.blockContentChanged(this.block.id, false);
                    
					// Fire BlockSaved event.
					this.onBlockSaved();
                    
				}, this)
			)
			.error($.proxy
            (
				function() 
                {
                    
                    saveButton.enable(true);
                    saveButton.flash(true, true);
                    
				}, this)
                
			).success($.proxy
            (
				function() 
                {
					saveButton.enable(false);
                    
				}, this)
                
			).complete($.proxy
            (
            
                function()
                {
                    
                    this.enable(true);
                    
                }, this)
                
            );
		}
		
        /**
        * 
        */
        this.bind = function(event, callback)
        {
            return this.block.box.bind(getEventName(event), callback);
        };
        
        this.unbind = function(event, callback)
        {
            return this.block.box.unbind(getEventName(event), callback);
        };
                
		/**
		*
		*
		*
		*
		*/
		this.switchEditorLanguage = function( lang )
        {
            
            var jBlk = this.block.box
            var jEle = jBlk.find('.cjt-panel-window-editor-tools .editor-lang .cjt-block-editor-tools-action.editor-lang-' + lang).eq(0);
            
            var currentLang = this.block.get('editorLang');
            
			// Set editor mode.
			this.block.aceEditor.getSession().setMode('ace/mode/' + lang);
			
            // Store editor lanaguage into block session store
			this.block.set('editorLang', lang);

            // Reflect UI selected language
            jEle.parent().find('.cjt-block-editor-tools-action').removeClass('cjt-action-active');
            
            jEle.addClass('cjt-action-active');
            
            this.trigger('SwitchEditorLanguage', [currentLang, lang]);
            
            return false;
		};
		
        /**
        * 
        */
        this.closePanel = function()
        {

            var wnd = $(window);
            var block = this.block;
            var pagesBlock = block.box.find('.cjpageblock');
            var codeBlock = block.box.find('.cjcodeblock');
            var aceEditor = block.aceEditor;
            var panel = this.panel;

            wnd.off('resize.block-panel');
            
            // Close panel
            pagesBlock.css({'display' : 'none' });
            
            codeBlock.css({'width' : '100%'});

            aceEditor.resize();
            
            panel.CJTDropDownPanel('inactivatePanels');
            
            this.trigger('ClosePanel');
        };
        
        /**
        * 
        */
        this.openPanel = function()
        {

            var wnd = $(window);
            var block = this.block;
            var pagesBlock = block.box.find('.cjpageblock');
            var codeBlock = block.box.find('.cjcodeblock');
            var aceEditor = block.aceEditor;
            var $this = this;
            
            var dockingPanel = function()
            {
                
                var openPanel = function() 
                {
                    
                    // Show panel
                    pagesBlock.css({'display' : 'block'});
                    
                    // Refresh editor
                    aceEditor.resize();
                    
                    $this.trigger('OpenPanel');
                    
                };
                
                var width = (wnd.width() <= $this.twoRowWidth) ? '100' : '65';
                
                codeBlock.css({'width' : width + '%'});
                
                openPanel();
            };
            
            // Refresh panel when resizing (originally made for switching between normal and lanscape more)
            wnd.off('resize.block-panel')
                .on('resize.block-panel', $.proxy(dockingPanel, this));
            
            // Initially docking the panel
            dockingPanel.call(this);
        };
        
		/**
		*
		*
		*
		*
		*/
		this.enable = function(state) 
        {
            
			var elements = this.block.box.find('input:text.block-name');
            
            if (state == true)
            {
                
                elements.removeAttr('disabled');
                
                this.trigger('enabled');
                
            }
            else 
            {
                elements.attr('disabled', 'disabled');
                
                this.trigger('disabled');
            }
            
            this.trigger('ChangeState', [state]);
            
            this.panel.CJTDropDownPanel('setPanelState', ['code-files-manager', 'templates-lookup'], state);
            
			// Enable or Disable ACEEditor.
			// Enable = true then setReadnly = false and vise versa.
			this.block.aceEditor.setReadOnly(!state);
		}
		
		/**
		* Make block code is the active element.
		*
		* @return false.
		*/		
		this.focus = function() 
        {
			this.block.aceEditor.focus();
		}
		
        /**
        * put your comment there...
        * 
        * @param event
        */
        var getEventName = function(event)
        {
            return eventNamePrefix + event;
        };
        
		/**
		* Initialize Block Plugin object.
		*
		*
		*/
		this.initCJTPluginBase = function(node, args) 
        {
            
			// Initialize object properties!
			var model = this.block = new CJTBlock(this, node);
			this.features = $.extend(defaultOptions, args);
            
            // Set theme object.
            this.theme = 
            {
                backgroundColor : '#f7f7f7', 
                color : 'inherit',
                borderColor : '#424242',
                link : 
                {
                    color : '#424242',
                    visited : '#424242', 
                    bgColor : 'white', 
                    hover : '#a0a0a0'
                }
            };
            
			// Initialize Events.
			this.onBlockSaved = function() {};
            
			// Load commonly used elements.
			this.elements = {};
			$.each(autoLoadElements, $.proxy(
            
				function(name, selector) 
                {
					this.elements[name] = this.block.box.find(selector);
				}, this)
                
			);
            
			// Move edit-block-name edit area and tasks-bar outside Wordpress metabox "inside div".
			this.elements.insideMetabox.before(model.box.find('.block-state-toolbox, .edit-block-name, .block-manage-toolbox, .block-panel-toolbox'));

            // Tool buttons
            this.stateToolbox = model.box.find('.block-state-toolbox').CJTToolBox(
            {
                context : this,
                
            }).get(0).CJTToolBox;
            
			// Save and Delete Toolbox
            this.manageToolbox = model.box.find('.block-manage-toolbox').CJTToolBox(
            {
                
                context : this,
                
                handlers : 
                {
                    'save' : {callback : this._onsavechanges, params : {enable : false}},
                    'delete' : {callback : this._ondelete},
                }
                
            }).get(0).CJTToolBox;

            this.panelToolbox = model.box.find('.block-panel-toolbox').CJTToolBox(
            {
                
                context : this,
                
                handlers : 
                {
                    'panel-list' : 
                    {
                        type : 'Popup',
                        params : {
                            // Parameters for PopupList type button.
                            _type : {
                                
                                onPopup : this._onpopupmenu,
                                targetElement : '.cjt-block-panels-list'
                            }
                        }
                    },
                }
            }).get(0).CJTToolBox;
            
            // Initialized-event (Regardless if loaded or not)
            this.trigger('Initialized', [this]);
            
			// If the code editor element is presented then
			// the block is already opened and no need to load later.
			if (model.box.find('.code-editor').length) 
            {
                
				this.loadTLE();
                
			}
            else
            {
                
                model.box.addClass('closed');
                
                // Initially closed Block event
                this.trigger('InitiallyClosed', [this]);
            }
            
			// Display block. 
			// !important: Blocks come from server response doesn't need this but the newly added blocks does.
			// need sometime to be ready for display.
			model.box.css({display : 'block'}).addClass('cjt-block').addClass('nor-display-mode');
		}
		
		/**
		* 
		*/
		this._onload = function() 
        {
			// Initialize.
			var model = this.block;
			// Show loading block progress.
			var loadingPro = $('<div class="loading-block">' + CJTJqueryBlockI18N.loadingBlock + ' . . .</div>').prependTo(this.elements.insideMetabox.prepend());
            
			// Retrieve Block HTML content.
			CJTBlocksPage.server.send('blocksPage', 'loadBlock', {blockId : model.get('id'), isLoading : true})
            
			.success($.proxy(
            
				function(blockContent) 
                {					
                    
					// Remove loading bloc progress.
					loadingPro.remove();
                    
					// Add assignment panel at the most begning of the block.
					this.elements.insideMetabox.prepend(blockContent.assignPanel);
                    
					// Add block content at the end.
					this.elements.insideMetabox.append(blockContent.content);
                    
					// Load block.
					this.loadTLE();
                    
				}, this)
                
			);
		};
		
		/**
		* 
		*/
		this.load = function() 
		{
			
			var model = this.block;
			
			// Broadcast block event
			model.box.trigger('cjtBlockLoaded', [this]);
			
			// LOAD MODEL.
			model.load();
			
			// Editor default options.
			this.block.aceEditor.setOptions({showPrintMargin : false});
            
            // Simply Code File object
            this.codeFile = new function()
            {
                this.file = new function()
                {
                    this.activeFileId = 1;
                }
            };
            
            model.box.trigger('cjtBlockAfterLoad', [this]);
            
			// Default to DOCK!!
			this.defaultDocks = 
            [
            
                {
                    element : this.block.aceEditor.container, 
                    pixels : 12
                }
                
            ];
            
			this.manageToolbox.buttons['save'].jButton.removeClass('waitingToLoad');
            
			// Register COMMAND-KEYS.
			this.registerCommands();
            
			// Prepare input elements for notifying user changes.
			this.notifySaveChanges = (new notifySaveChangesProto(this)).initDIFields();
			
			// LOAD EVENT.
			if (this.onLoad !== undefined) 
            {
				this.onLoad();	
			}
            
            // Editor Toolbox Modifiers/Containers/Namespaces
            var modifiers = 
            {
                '' : this
            };
            
            this.trigger('EditorToolBoxModifiers', [modifiers]);
                    
            // Editor Tools Panel
            model.box.find('.cjt-panel-window-editor-tools a.cjt-block-editor-tools-action').each($.proxy(
            
                /**
                * 
                */
                function(index, ele)
                {
                    // Get action name
                    var jEle = $(ele);
                    var action = {};
                    
                    action.fullName = jEle.prop('href').match(/\#(.+)/)[1];
                    
                    // Default modifier if the block object instance
                    if (action.fullName.indexOf('.') == -1)
                    {
                        action.fullName = '.' + action.fullName;
                    }
                    
                    action.compoundName = action.fullName.split('.');
                    action.modifier = action.compoundName[0];
                    action.name = action.compoundName[1];
                    action.params = action.name.match(/\((.+)\)/);
                    
                    // consider non-paramterize calls
                    if (!action.params)
                    {
                        action.params = [];
                    }
                    else
                    {
                        // Split to params array
                        action.params = action.params[1].split(',');
                    }
                    
                    action.methodName = action.name.match(/([^\(]+)/)[0];
                    
                    // Bind to modifier handlers
                    jEle.click($.proxy( 
                    
                        function(event)
                        {
                            
                            action.params.push(event);
                            
                            modifiers[action.modifier][action.methodName].apply(this, action.params);
                            
                            return false;
                        }
                        
                    , this ) );
                    
                }
            
            , this ) );
            
            
            // List Panel
            this.panel = this.block.box.find( '.cjt-block-panels-list' ).CJTDropDownPanel( 
            { 
                
                panelsScope : this.block.box,
                display : this.block.box.find( '.cjpageblock' ),
                context : this,
                panelGenericClass : 'cjt-block-panel-window',
                closePanelHandler : $.proxy(this.closePanel, this),
                
                onPanelClick : function( event, cInfo, opts, panel )
                {
                    
                    // If already opened, close the panel area
                    if ( cInfo.isActive == true )
                    {
                        
                        opts.context.closePanel();
                        
                        CJTBlocksPage.blocksForm.data( 'activePanelBlock', null );
                        
                        cInfo.cancel = true
                        
                    }
                    else 
                    {
                        // Only one block panel allowed to be opened at a time
                        // make sure that only this bloick has panel area opened
                        var activePanelBlock = CJTBlocksPage.blocksForm.data( 'activePanelBlock' );
                        
                        // Close active block only if there is one activated and its not the current block
                        if ( activePanelBlock && ( activePanelBlock !== opts.context ) )
                        {
                            activePanelBlock.closePanel();

                        }
                        
                        // Set active panel block
                        CJTBlocksPage.blocksForm.data( 'activePanelBlock', opts.context );
                        
                        // Open Panel if not yet opened
                        var panelArea = opts.context.block.box.find( '.cjpageblock' );
                        
                        if ( ! panelArea.hasClass( 'panelOpened' ) )
                        {
                            opts.context.openPanel();
                        }
                        
                    }
                    
                    opts.context.panelToolbox.buttons['panel-list'].close();
                    
                    opts.context.trigger('SwitchPanel');
                    
                },
                
                handlers :
                {
                    'block-info' : { callback : this._ongetinfo }
                }
            
            } );
            
            this.block.box.trigger('cjtblockpanelitems', [this.panel]);
            
		};
        
        /**
        * Load and Trigger Load events
        * 
        */
        this.loadTLE = function()
        {
            
            // Pre loaded event
            this.trigger('preloaded');
            
            //  Load Block
            this.load();
            
            // Switch Block state if required, if state is empty nothing will happen.
            // Until now only 'restore' state is supported to prevent saving restored block.
            this.switchState(this.features.state);
            
            // Its important to trigger at last !
            this.trigger('postloaded');
        }

		/**
		* 
		*/
		this.registerCommands = function() {
			var editorCommands = this.block.aceEditor.commands;
			var commands = [
				{
					name: 'Save-Changes',
					bindKey: {
						win : 'Ctrl-S',
						mac : 'Command-J'
					},
					exec: $.proxy(this._onsavechanges, this)
				}
			];
			/** Add Our Ace Save, Full screen and Code-Auto-Completion commands */
			editorCommands.addCommands(commands);
		}
		
		/**
		* 
		*/
		this.restoreRevision = function(revisionId, data) {
			// Create new revision control action.
			this.revisionControl = new CJTBlockOptionalRevision(this, data, revisionId);
			// Display the revision + enter revision mode.
			this.revisionControl.display();
		}
		
		/**
		* 
		*/
		this.setFeatures = function( features )
		{
			this.features = features;
		};
		
		/*
		*
		*
		*
		*/
		this.switchState = function(state) 
        {
            
			switch (state) 
            {
                
				case 'restore':
                
					// Hide block toolbox.
					this.manageToolbox.jToolbox.hide();
                    this.stateToolbox.jToolbox.hide();
                    
					// Disable all fields.
					this.enable(false);
                    
                    // Block cannot be closed in backup mode
                    this.block.box.find('.handlediv.button-link').hide();
                    
                    this.trigger('BackupMode');
                    
					// Change state
					this.state = 'restore';
                    
                break;
                
                case 'revision':

                    this.trigger('RevisionMode');
                    
                    this.state = 'restore';
                
                break;
                
				default:
                
                    this.enable(true);
                    
                    this.trigger('DefaultMode');
                    
                    this.block.box.find('.handlediv.button-link').show();
                     
				break;
			}
		}
        
        /**
        * 
        */
        this.trigger = function(event, params)
        {
            
            // Event prefixed name
            var fullEventName = getEventName(event);
            
            if (params == undefined)
            {
                params = [];
            }
            
            // Always send block instance as first parameter
            params.unshift(this);

            // Trigger
            return this.block.box.trigger(fullEventName, params);
        };
		
	} // End class.
	
	/**
	*	jQuery Plugin interface.
	*/
	$.fn.CJTBlock = function(args) {
		/**
		* Process every block object.
		*/		
		return this.each(function() {
			
			// If this is the first time to be called for this element
			// create new CJTBlockPlugin object for the this element.
			if (this.CJTBlock == undefined) {
				this.CJTBlock = new CJTBlockPlugin(this, args);
			}
			else {
				// Otherwise change options
				this.CJTBlock.setOptions(args);
			}
			return this;
		});
		
	} // End Plugin class.

})(jQuery);