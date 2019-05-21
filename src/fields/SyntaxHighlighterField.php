<?php
/**
 * Syntax Highlighter plugin for Craft CMS 3.x
 *
 * The power of Prism syntax highlighting in Craft
 *
 * @link      http://hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\syntaxhighlighter\fields;

use hashtagerrors\syntaxhighlighter\SyntaxHighlighter;
use hashtagerrors\syntaxhighlighter\assetbundles\SyntaxHighlighterField\SyntaxHighlighterFieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Hashtag Errors
 * @package   SyntaxHighlighter
 * @since     1.0.0
 */
class SyntaxHighlighterField extends Field
{
    // Public Properties
    // =========================================================================

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('syntax-highlighter', 'Syntax Highlighter');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        if(is_string($value)){
            $value = Json::decode($value, true);
        }
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'syntax-highlighter/_components/fields/SyntaxHighlighterField_settings',
            [
                'field' => $this,
            ]
        );
    }

    public function selectedLangauges()
    {
        return SyntaxHighlighter::$plugin->syntaxHighlighterService->getSelectedLangauges();
    }
    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(SyntaxHighlighterFieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);
        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').SyntaxHighlighterSyntaxHighlighterField(" . $jsonVars . ");");
        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'syntax-highlighter/_components/fields/SyntaxHighlighterField_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'selectedLangauges' => $this->selectedLangauges()
            ]
        );
    }
}
