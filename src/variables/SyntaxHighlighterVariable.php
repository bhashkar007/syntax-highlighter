<?php
/**
 * Syntax Highlighter plugin for Craft CMS 3.x
 *
 * The power of Prism syntax highlighting in Craft
 *
 * @link      http://hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\syntaxhighlighter\variables;

use hashtagerrors\syntaxhighlighter\SyntaxHighlighter;

use Craft;
use craft\web\View;
use craft\helpers\Json;

/**
 * @author    Hashtag Errors
 * @package   SyntaxHighlighter
 * @since     1.0.0
 */
class SyntaxHighlighterVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    public function render($field)
    {
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        
        $setting = SyntaxHighlighter::$plugin->getSettings();
        echo Craft::$app->view->renderTemplate('syntax-highlighter/_render/_codeblock', [
            'field' => $field,
            'setting' => $setting
        ]);
        
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_SITE);
    }
}
