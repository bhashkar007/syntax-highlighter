<?php
/**
 * Syntax Highlighter plugin for Craft CMS 3.x
 *
 * The power of Prism syntax highlighting in Craft
 *
 * @link      http://hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */


namespace hashtagerrors\syntaxhighlighter\jobs;

use hashtagerrors\syntaxhighlighter\SyntaxHighlighter;

use Craft;
use craft\queue\BaseJob;

/**
 * @author    Hashtag Errors
 * @package   SyntaxHighlighter
 * @since     1.1.0
 */
class BuildFilesTask extends BaseJob
{
    // Public Properties
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $errors = [];

        try {
            SyntaxHighlighter::$plugin->syntaxHighlighterService->bulidFiles();
        } catch (\Throwable $e) {
            Craft::error('Error building files: ' . $e->getMessage());
        }
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function defaultDescription(): string
    {
        return Craft::t('syntax-highlighter', 'Building Syntax Highlight CSS & JS Files.');
    }
}
