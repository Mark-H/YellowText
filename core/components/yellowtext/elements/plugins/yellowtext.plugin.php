<?php
/**
 * @todo add licensing
 *
 * @package yellowtext
 * @var modX $modx
 * @var array $scriptProperties
 *
 * @var bool $useEditor
 * @var string $whichEditor
 */

$eventName = $modx->event->name;
switch ($eventName) {
    case 'OnRichTextEditorRegister':
        $modx->event->output('YellowText');
        return;
        break;

    case 'OnRichTextBrowserInit':
        //$modx->event->output('<!-- foooooooo bar -->');
        break;
    case 'OnRichTextEditorInit':

        $useEditor = $modx->getOption('use_editor');
        $whichEditor = $modx->getOption('which_editor');
        if ($useEditor && ($whichEditor == 'YellowText')) {
            $assetsUrl = $modx->getOption('yellowtext.assets_url', null, $modx->getOption('assets_url').'components/yellowtext/');

            $modx->regClientCSS($assetsUrl.'stylesheets/jquery.texteditor.css');
            $modx->regClientStartupScript('//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js');
            $modx->regClientStartupScript($assetsUrl.'javascripts/jquery.texteditor.js');

            $options = $modx->toJSON(array(
                'foo' => 'bar',
            ));
            $html = "<script type=\"text/javascript\">
                MODx.loadRTE = function() {
                    var options = $options;
                    var panel = Ext.getCmp('modx-panel-resource');
                    options.formID = panel.getForm().id;
                    var elements = panel.rteElements;
                    if (Ext.isString(elements)) {
                        var textarea = $('#'+elements);
                        textarea.text(panel.record.content);
                        setTimeout(function() {
                            textarea.texteditor();
                        }, 1000);
                    }
                };
            </script>";
            $modx->event->output($html);
        }
        break;

}

if ($modx->event->name == 'OnRichTextEditorRegister') {
    $modx->event->output('TinyMCE');
    return;
}
