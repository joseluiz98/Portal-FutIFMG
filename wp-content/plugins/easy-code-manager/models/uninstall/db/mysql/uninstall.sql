/*
* Delete CJT Tables
*/
DROP TABLE IF EXISTS #__cjtoolbox_backups;
DROP TABLE IF EXISTS #__cjtoolbox_blocks;
DROP TABLE IF EXISTS #__cjtoolbox_block_pins;

/* Added Version 1.3 */
DROP TABLE IF EXISTS #__cjtoolbox_parameters;
DROP TABLE IF EXISTS #__cjtoolbox_parameter_typedef;
DROP TABLE IF EXISTS #__cjtoolbox_forms;
DROP TABLE IF EXISTS #__cjtoolbox_form_groups;
DROP TABLE IF EXISTS #__cjtoolbox_form_group_parameters;
DROP TABLE IF EXISTS #__cjtoolbox_parameter_typeparams;
/* Added Version 1.4 */
DROP TABLE IF EXISTS #__cjtoolbox_form_group_xfields;
/* TABLE: Added Version 1.5 */
DROP TABLE IF EXISTS #__cjtoolbox_block_files;
/* CLEANUP MASTER FILE MET: Added Version 1.5 */
DELETE FROM #__wordpress_usermeta where meta_key like 'cjt_block_active_file_%';

/*  Database version number (By this option CJT Plugin detect installation state!) */
DELETE FROM #__wordpress_options where option_name = 'ecm_db_version';

/* Clean up installer state */
DELETE FROM #__wordpress_options WHERE option_name = 'state.CJTInstallerModel.operations';
DELETE FROM #__wordpress_usermeta WHERE meta_key = '#__wordpress_settings.CJTInstallerModel.noticeDismissed';

/* Delete Cached Premium Licence keys */
DELETE FROM #__wordpress_options WHERE option_name = 'cache.CJTSetupModel.licenses';

/* Remove metabox order */
DELETE FROM #__wordpress_usermeta where meta_key = 'meta-box-order_ecm';
DELETE FROM #__wordpress_options where option_name = 'meta-box-order_ecm';

/* Closed metaboxes */
DELETE FROM #__wordpress_usermeta where meta_key = 'closedpostboxes_cjtoolbox';

/* User Settings */
DELETE FROM #__wordpress_options where option_name = 'cjt-settings.CJTSettingsMetaboxPage';
DELETE FROM #__wordpress_options where option_name = 'cjt-settings.CJTSettingsUninstallPage';

/*  Posts Metabox blocks */
DELETE FROM #__wordpress_postmeta where meta_key = '__CJT-BLOCK-ID';
DELETE FROM #__wordpress_postmeta where meta_key = '__CJT-BLOCK-STATUS'