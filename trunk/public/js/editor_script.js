var userresult;
tinyMCE.init({
	plugins : '-example', // - tells TinyMCE to skip the loading of the plugin
	mode : "textareas",
	theme : "advanced",
	editor_selector : "mceEditor",
	theme_advanced_buttons1 : "mymenubutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,fontselect,fontsizeselect,numlist,undo,redo,link,unlink",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom"
});
