<?php
/**
 * Syntax Highlighter plugin for Craft CMS 3.x
 *
 * The power of Prism syntax highlighting in Craft
 *
 * @link      http://hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\syntaxhighlighter;

use hashtagerrors\syntaxhighlighter\models\Settings;
use hashtagerrors\syntaxhighlighter\jobs\BuildFilesTask;
use hashtagerrors\syntaxhighlighter\services\SyntaxHighlighterService;
use hashtagerrors\syntaxhighlighter\variables\SyntaxHighlighterVariable;
use hashtagerrors\syntaxhighlighter\fields\SyntaxHighlighterField as SyntaxHighlighterField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\services\Fields;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class SyntaxHighlighter
 *
 * @author    Hashtag Errors
 * @package   SyntaxHighlighter
 * @since     1.0.0
 *
 */
class SyntaxHighlighter extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var SyntaxHighlighter
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = SyntaxHighlighterField::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    $this->buildFiles();
                }
            }
        );

        // when plugin settings are saved
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_SAVE_PLUGIN_SETTINGS,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    $this->buildFiles();
                }
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('syntaxHighlighter', SyntaxHighlighterVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'syntax-highlighter',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }
    public function availableLangauges()
    {
        return SyntaxHighlighter::$plugin->syntaxHighlighterService->getAvailableLangauges();
    }
    public function selectedLangauges()
    {
        return SyntaxHighlighter::$plugin->syntaxHighlighterService->getSelectedLangauges();
    }
    public function availableThemes()
    {
        return SyntaxHighlighter::$plugin->syntaxHighlighterService->getAvailableThemes();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'syntax-highlighter/settings',
            [
                'settings' => $this->getSettings(),
                'langauges' => $this->availableLangauges(),
                'selectedLangauges' => $this->selectedLangauges(),
                'themes' => $this->availableThemes()
            ]
        );
    }

    protected function buildFiles()
    {
        Craft::$app->getQueue()->delay(0)->push(new BuildFilesTask());
    }
}
