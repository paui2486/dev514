/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'zh';
  // config.allowedContent=true;

  // config.removeButtons = 'Underline,Subscript,Superscript';

  // config.filebrowserUploadUrl = '';
  // config.filebrowserBrowseUrl = '/assets/ckfinder/ckfinder.html';
  // config.filebrowserImageBrowseUrl = '/assets/ckfinder/ckfinder.html?Type=Images';
  // config.filebrowserFlashBrowseUrl = '/assets/ckfinder/ckfinder.html?Type=Flash';
  config.filebrowserUploadUrl = '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
  config.filebrowserImageUploadUrl = '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
  config.filebrowserFlashUploadUrl = '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

  // config.font_names = 'Arial;Arial Black;Comic Sans MS;Courier New;Tahoma;Times New Roman;Verdana;新細明體;細明體;標楷體;微軟正黑體';
  // config.fontSize_sizes ='8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;15/15px;16/16px;17/17px;18/18px;19/19px;20/20px;21/21px;22/22px;23/23px;24/24px;25/25px;26/26px;28/28px;36/36px;48/48px;72/72px'


	// config.uiColor = '#AADC6E';
};
