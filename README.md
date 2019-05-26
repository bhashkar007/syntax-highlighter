

# Syntax Highlighter

The power of Prism syntax highlighting in Craft.

![Screenshot](http://www.hashtagerrors.com/assets/uploads/prism.jpg)

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require hashtagerrors/syntax-highlighter

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Syntax Highlighter.

## Syntax Highlighter Overview

**Syntax Highlighter Setting**

[Prism](https://prismjs.com) is one of the most popular syntax highlighters that widely used by a lot of blog or websites due to it's ability to do custom builds of the language highlighter and plugins you want to be used. 

This plugin helps you to similarly build Prism files by selecting desired languages, plugins and theme and then finally bring  code highlighter in frontend with a single line of code. 

Plugin setting page has 178 languages, 8 themes & 4 plugins to select from. Once you choose desired languages, theme and plugins, the plugin builds a JS and CSS file based on the selection which is then automatically fetched when called in frontend.
 
![Screenshot](http://www.hashtagerrors.com/assets/uploads/prism-setting-page.jpg)
 
**Syntax Highlighter Field**

The plugin adds a `Syntax Highlighter` fieldtype which then displays a block to add your code, select code type, add a caption and specify the lines to be highlighted (if enabled in plugin setting).

![Screenshot](http://www.hashtagerrors.com/assets/uploads/prism-fieldtype.jpg)

**Syntax Highlighter Frontend**

Using`{{ craft.syntaxHighlighter.render(entry.fieldHandle) }}` in template will show the highlighted code in the frontend.
![Screenshot](http://www.hashtagerrors.com/assets/uploads/prism-frontend.jpg)

## Configuring Syntax Highlighter

The Plugin has following settings:

**Choose Languages** (Required)
Choose the Languages that should be enabled. As this is a required field atleast 1 language needs to be selected. 
Default `Markup, CSS, C-like, JavaScript, Twig`. 

**Default Language**
The language that would be selected by default in the drop down menu in Code Block Field. 
Default `Twig`

**Theme**
The Prism theme you would like to enable in frontend. 
Default `Prism`

**Line Numbers**
To enable Line Numbers in the code block. Default 
Default `Prism`

**Line Highlight**
To enable Line Highlight in the code block.
Default `True`

**Show Language**
To show language used in the code block.
Default `False`

**Copy to Clipboard Button**
To enable Copy to Clipboard Button
Default `True`

**Max Height**
To set maximum height(in px) of code container to avoid long scrolling in case of long code. 
Default `500`
Leave empty or enter 0 to disable scroll.

NOTE: Since this plugin build files every time it's plugin setting is saved, the plugin directory should have **Write** permission. specifically for the`hashtagerrors\syntax-highlighter\src\assetbundles\syntaxhighlighterfrontend` folder. 

## Using Syntax Highlighter

 1. Select desired languages, theme and plugin from setting page.
 2. Create a new field with `Syntax Highlighter` fieldtype.
 3. Add field in your section.
 4. Copy Paste or write down your code in the textarea of the the Code block,
 5. Select language from the Code Type dropdown.
 6. Enter line number(s) to be highlighted (if enabled in plugin setting). 
 7. Add a Caption to show a text on below code block (optional).
 8. Use `{{ craft.syntaxHighlighter.render(entry.fieldHandle) }}` in template to show highlighted code.

## Syntax Highlighter Roadmap

* Ability to add custom CSS by user.
* Prism's [File Highlight](https://prismjs.com/plugins/file-highlight/) plugin.
* Prism's Other plugins.

New ideas are always welcome. You can post your ideas, requrest or issue [here](https://github.com/hashtagerrors/syntax-highlighter/issues)

Brought to you by [Hashtag Errors](http://hashtagerrors.com)
