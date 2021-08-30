<?php
/**
 * Syntax Highlighter plugin for Craft CMS 3.x
 *
 * The power of Prism syntax highlighting in Craft
 *
 * @link      http://hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\syntaxhighlighter\assetbundles\SyntaxHighlighterField;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Hashtag Errors
 * @package   SyntaxHighlighter
 * @since     1.0.0
 */
class SyntaxHighlighterFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@hashtagerrors/syntaxhighlighter/assetbundles/syntaxhighlighterfield/dist";

        $this->depends = [
            CpAsset::class
        ];

        $this->js = [
            'js/SyntaxHighlighterField.js',
        ];

        $this->css = [
            'css/SyntaxHighlighterField.css',
        ];

        parent::init();
    }
}
