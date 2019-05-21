/**
 * Syntax Highlighter plugin for Craft CMS
 *
 * Syntax Highlighter JS
 *
 * @author    Hashtag Errors
 * @copyright Copyright (c) 2019 Hashtag Errors
 * @link      http://hashtagerrors.com
 * @package   SyntaxHighlighter
 * @since     1.0.0
 */

var lang_tobe_checked = [];

$('.syntaxhighlighter-container').delegate('input', 'click', function(e, type){

	var $this = $(this),
		lang = $this.val(),
		lang_name = $.trim($this.parent().text());

	
	// Change state from unchecked to checked
	if ($this.is(':checked') && lang != '*')
	{
		var prefix = lang.substr(0,3);
		// Check dependency
		
		if (prefix == 'add') {
			var lang_component = {};
			lang_component.require = undefined;
		} else {
			var lang_component = components.languages[lang];
		}
		
		var lang_required = [],
			curr_lang = {'lang':lang, 'lang_name': lang_name};
		
				
		// Save dependency fo build later				
		lang_tobe_checked.push(curr_lang);
		if ( lang_component.require != undefined)
		{
			lang_required = lang_component.require;
			if (typeof lang_required == 'string') {
				lang_required = [lang_required];
			}

			for (k in lang_required)
			{	
				//console.log(lang_required[k]);
				var $checkbox =  $('.syntaxhighlighter-container input[value=' + lang_required[k] + ']')
				// Click the dependency
				if (!$checkbox.is(':checked')) {
					$checkbox.click();
				}
			}
		}
	}
})