/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

require('codemirror/mode/htmlmixed/htmlmixed');
require('codemirror/mode/css/css');
const CodeMirror = require('codemirror/lib/codemirror');

document.addEventListener('DOMContentLoaded', () => {
    const codemirrorTextarea = document.querySelectorAll('.codemirror-editor');
    const codeMirrorInstances = [];
    const accordions = $('[name="bitbag_sylius_mail_template_plugin_template_email"] .ui.accordion');

    accordions.on('click', () => {
        codeMirrorInstances.forEach((codeMirrorInstance) => {
            codeMirrorInstance.refresh();
        });
    });

    codemirrorTextarea.forEach((textarea) => {
        const codemirror = CodeMirror.fromTextArea(textarea, {
            lineNumbers: true,
            mode: textarea.dataset.language,
            theme: 'idea',
            extraKeys: {
                'Ctrl-Space': 'autocomplete'
            },
        });

        codemirror.on('change', () => {
            textarea.value = codemirror.getValue();
        });

        codeMirrorInstances.push(codemirror);
    });
});
