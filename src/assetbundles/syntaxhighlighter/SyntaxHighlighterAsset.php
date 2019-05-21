<?php
/**
 * Syntax Highlighter plugin for Craft CMS 3.x
 *
 * The power of Prism syntax highlighting in Craft
 *
 * @link      http://hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\syntaxhighlighter\assetbundles\SyntaxHighlighter;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
/**
 * @author    Hashtag Errors
 * @package   SyntaxHighlighter
 * @since     1.0.0
 */
class SyntaxHighlighterAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@hashtagerrors/syntaxhighlighter/assetbundles/syntaxhighlighter/dist";

        $this->depends = [
            CpAsset::class
        ];

        $this->js = [
            'js/SyntaxHighlighter.js'
        ];

        $this->css = [
            'css/SyntaxHighlighter.css',
        ];

        parent::init();
    }
}
