<?php
/**
 * Syntax Highlighter plugin for Craft CMS 3.x
 *
 * The power of Prism syntax highlighting in Craft
 *
 * @link      http://hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\syntaxhighlighter\models;

use hashtagerrors\syntaxhighlighter\SyntaxHighlighter;

use Craft;
use craft\base\Model;

/**
 * @author    Hashtag Errors
 * @package   SyntaxHighlighter
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $selectedLanguages = array(
        "markup",
        "css",
        "clike",
        "javascript",
        "twig"
    );
    public $defaultLanguage = "twig";
    public $selectedTheme = "prism";
    public $enableLineHighlight;
    public $enableLineNumbers = true;
    public $showLanguage;
    public $copytoClipboardButton = true;
    public $maxHeight = 500;

    public function rules()
    {
        return [
            [['selectedLanguages'], 'required']
        ];
    }
}
