<?php
/**
 * Syntax Highlighter plugin for Craft CMS 3.x
 *
 * The power of Prism syntax highlighting in Craft
 *
 * @link      http://hashtagerrors.com
 * @copyright Copyright (c) 2019 Hashtag Errors
 */

namespace hashtagerrors\syntaxhighlighter\services;

use hashtagerrors\syntaxhighlighter\SyntaxHighlighter;

use Craft;
use craft\base\Component;

/**
 * @author    Hashtag Errors
 * @package   SyntaxHighlighter
 * @since     1.0.0
 */
class SyntaxHighlighterService extends Component
{
    // Public Methods
    // =========================================================================

    public function getComponents()
    {   
        if (!defined('SH__DS')) {
            define ('SH__DS', DIRECTORY_SEPARATOR);
        }
        $dir = dirname(__DIR__, 1);
        $contents =  file_get_contents($dir . SH__DS .'resources'. SH__DS .'components.json');
        $components = json_decode($contents, true);
        // Languages 
        foreach ($components as $item => $val) 
        {
            if ($item == 'languages') {
                foreach($val as $component_name => $item) {
                    if ($component_name == 'meta') {
                        continue;
                    }
                    $components_list['lang-list'][$component_name] = $item;
                }
                
                $components_list['lang-list']['adddarkplain'] = array('title' => 'Dark Plain');
                $components_list['lang-list']['addlightplain'] = array('title' => 'Light Plain');
            }
            
            if ($item == 'themes') {
                foreach($val as $theme_name => $item) {
                    if ($theme_name == 'meta') {
                        continue;
                    }
                    if (is_array($item)) {
                        $title = $item['title'];
                    } else {
                        $title = $item;
                    }
                    $components_list['themes'][$theme_name] = $title;
                }
            }
            
            if ($item == 'plugins') {
                foreach($val as $theme_name => $item) {
                    if ($theme_name == 'meta') {
                        continue;
                    }
                    if (is_array($item)) {
                        $title = $item['title'];
                    } else {
                        $title = $item;
                    }
                    $components_list['plugins'][$theme_name] = $title;
                }
            }
        }

        return $components_list;
    }
    
    public function getSelectedLangauges()
    {
        $selectedLangauges = SyntaxHighlighter::$plugin->getSettings()->selectedLanguages;
        if(empty($selectedLangauges)){
            $selectedLangauges = array();
        }
        $components = $this->getComponents();
        $lang_list = $components['lang-list'];
        $selectedLangaugesList = array();
        foreach ($selectedLangauges as $selectedLangauge){   
            foreach ($lang_list as $lang_key => $item){
                if ( $lang_key == $selectedLangauge ){
                    $selectedLangaugesList[] = array(
                        'value' => $selectedLangauge, 
                        'label' => $item['title'] 
                    );
                }
            }
        }
        return $selectedLangaugesList;
    }
    
    public function getAvailableLangauges()
    {
        $components = $this->getComponents();
        $lang_list = $components['lang-list'];
        $languages = array();
        foreach ($lang_list as $lang_key => $item)
        {
            $languages[] = array(
                'value' => $lang_key, 
                'label' => $item['title'] 
            );
        }
        return $languages;
    }
    
    public function getAvailableThemes()
    {
        $components = $this->getComponents();
        $theme_list = $components['themes'];
        $themes = array();
        foreach($theme_list as $theme => $theme_name)
        {
            $themes[] = array(
                'value' => $theme, 
                'label' => $theme_name
            );
        }
        return $themes;
    }
    
    public function bulidFiles()
    {
        // BUILD PATH
        if (!defined('SH_DS')) {
            define ('SH_DS', DIRECTORY_SEPARATOR);
        }
        
        $upload_dir = dirname(__DIR__, 1);
        $build_path = $upload_dir . SH_DS . 'assetbundles' . SH_DS . 'syntaxhighlighterfrontend' . SH_DS . 'dist';
        
        if (!file_exists($build_path)) {
            mkdir($build_path, 0777);
        }
        
        $setting = SyntaxHighlighter::$plugin->getSettings();
        $components = $this->getComponents();
        $lang_list = $components['lang-list'];

        
        // Build prism with selected lang
        $path = $upload_dir . SH_DS .'resources'. SH_DS;

        $scripts = '';
        $addcss = '';

        //Add Core First
        $corefile = $path . 'components' . SH_DS . 'prism-core.js';
        if (file_exists($corefile)) {
            $scripts .= file_get_contents($corefile) . ';';
        }

        $lang_used = array();
        foreach ($setting['selectedLanguages'] as $lang) 
        {
            $lang_components = $lang_list[$lang];
            // add language's required js
            if(array_key_exists('require', $lang_components)){
                $lang_components_required = $lang_components['require'];
                if(is_array($lang_components_required)){
                    foreach ($lang_components_required as $lang_required) {
                        if (!in_array($lang_required, $lang_used)) {
                            $addjsfile = $path . 'components' . SH_DS . 'prism-'.$lang_required.'.js';
                            if (file_exists($addjsfile)) {
                                $scripts .= file_get_contents($addjsfile) . ';';
                            }
                            $lang_used[] = $lang_required;
                        }
                    }
                }else{
                    if (!in_array($lang_components_required, $lang_used)) {
                        $addjsfile = $path . 'components' . SH_DS . 'prism-'.$lang_components_required.'.js';
                        if (file_exists($addjsfile)) {
                            $scripts .= file_get_contents($addjsfile) . ';';
                        }
                        $lang_used[] = $lang_components_required;
                    }
                }
            }
            $jsfile = $path . 'components' . SH_DS . 'prism-'.$lang.'.js';
            if (file_exists($jsfile)) {
                $scripts .= file_get_contents($jsfile) . ';';
            }
            $lang_used[] = $lang;
            if ($lang == 'adddarkplain' || $lang == 'addlightplain')
            {
                $addcss .= "\r\n" . 
                    "pre.aphph-adddarkplain,
                    pre.aphph-addlightplain {
                        padding: 7px 15px;
                        display: block;
                        font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
                        word-wrap: break-word;
                        font-size: 95%;
                        text-align: left
                    }
                    pre.aphph-addlightplain {
                        background: #f9f9f9; !important;
                        color: #4a4a4a;
                    }
                    pre.aphph-adddarkplain {
                        background: #131313 !important;
                        color: #CACACA;
                    }";
            }
        }
        /**
         * Add Plugins...
        */
    
        $plugin_path = $path . 'plugins' . SH_DS;
        $plugin_used = array();

        // line-highlight                     
        if ($setting['enableLineHighlight']) {
            $scripts .= file_get_contents($plugin_path . 'line-highlight' . SH_DS .'prism-line-highlight.js') . ';';
            $plugin_used[] = 'line-highlight';
        }

        // line-numbers                     
        if ($setting['enableLineNumbers']) {
            $scripts .= file_get_contents($plugin_path . 'line-numbers' . SH_DS .'prism-line-numbers.js') . ';';
            $plugin_used[] = 'line-numbers';
        }
        
        //show-language
        if ($setting['showLanguage']) {
            if(!in_array('toolbar', $plugin_used)){
                $scripts .= file_get_contents($plugin_path . 'toolbar' . SH_DS .'prism-toolbar.js') . ';';
                $plugin_used[] = 'toolbar';
            }
            $scripts .= file_get_contents($plugin_path . 'show-language' . SH_DS .'prism-show-language.js') . ';';
            $plugin_used[] = 'show-language';
        }

        //show-language
        if ($setting['copytoClipboardButton']) {
            if(!in_array('toolbar', $plugin_used)){
                $scripts .= file_get_contents($plugin_path . 'toolbar' . SH_DS .'prism-toolbar.js') . ';';
                $plugin_used[] = 'toolbar';
            }
            $scripts .= file_get_contents($plugin_path . 'copy-to-clipboard' . SH_DS .'prism-copy-to-clipboard.js') . ';';
            $plugin_used[] = 'copy-to-clipboard';
        }

        // file-highlight   
        // $scripts .= file_get_contents($plugin_path . 'file-highlight' . SH_DS .'prism-file-highlight.js') . ';';
        // $plugin_used[] = 'file-highlight';
        
        /**
            Script
        */  
        /* Cleanup the build directory */
        $files = scandir($build_path);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..')
                continue;
            unlink ($build_path . SH_DS . $file);
        }

        // We build with time() to make sure the client browser use our lastest build
        file_put_contents($build_path . SH_DS . 'prism.js', $scripts);
        
        /**
            Theme
        */
        
        // Get theme css
        if (strtolower($setting['selectedTheme']) == 'default'){
            $setting['theme'] = 'prism';
        }
        $prism_css = file_get_contents($path . 'themes' . SH_DS . $setting['selectedTheme']. '.css');
        
        // Get plugins css
        foreach ($plugin_used as $plugin)
        {
            $css_file = $path . 'plugins' . SH_DS . $plugin . SH_DS . 'prism-' . $plugin . '.css';
            if (file_exists($css_file))
            {
                $prism_css .= "\r\n" . file_get_contents($css_file);
            }
        }
        
        // ADDITIONAL CSS
        $prism_css .= $addcss;
        
        if (isset($setting['maxHeight']) && !empty($setting['maxHeight']) && $setting['maxHeight']!=0 ){
            $prism_css .= "\r\n" . 
            'pre.code-container {
                max-height: '.$setting['maxHeight'] .'px;  
            }';
        }
        
        $file_path = $build_path . SH_DS . 'prism.css';
        file_put_contents($file_path, $prism_css);
    }
}
