/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'styles' },
		{ name: 'colors' },
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.defaultLanguage = 'zh-tw';
	config.removeButtons = 'Underline,Subscript,Superscript';
	// config.undoStackSize = 10;
	// config.filebrowserBrowseUrl = 'html_edit_upload/ckfinder.html';
	// config.filebrowserImageBrowseUrl = 'html_edit_upload/ckfinder.html?Type=Image';
	// config.filebrowserFlashBrowseUrl = 'html_edit_upload/ckfinder.html?Type=Flash';
	config.filebrowserUploadUrl = 'html_edit_upload/core/connector/php/connector.php?command=QuickUpload&type=Files';
	// config.filebrowserImageUploadUrl = 'html_edit_upload/core/connector/php/connector.php?command=QuickUpload&type=Image';
	// config.filebrowserFlashUploadUrl = 'html_edit_upload/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
