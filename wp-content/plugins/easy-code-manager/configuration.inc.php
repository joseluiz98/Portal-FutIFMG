<?php
/**
* 
*/

/**
* 
*/
return (object) array
(
	'core' => (object) array
    (
    
        'siteHook' => ((object) array
        (
            'tag' => 'template_redirect',
            'priority' => 11))
        ),
        
	'database' => (object) array
    (
		'tables' => (object) array
        (
        
			'blocks' => 'cjtoolbox_blocks',
			'blockPins' => 'cjtoolbox_block_pins',
			'backups' => 'cjtoolbox_backups',
            
			'templates' => 'cjtoolbox_templates',
			'authors' => 'cjtoolbox_authors',
			'blockTemplates' => 'cjtoolbox_block_templates',
		),
	),
    
	'fileSystem'  => (object) array
    (
		'contentDir' => 'ecm-content',
	),
    
);