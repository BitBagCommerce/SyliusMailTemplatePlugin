/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

const axios = require('axios');
const emailTemplatePreviewButtons = document.querySelectorAll('.bitbag_preview_mail_template');
const mailPreviewModal = $('.mail-preview.modal');

mailPreviewModal
    .modal({
        onHidden: () => {
            document.querySelector('.mail-preview.modal > .content').innerHTML = '';
        },
        selector: {
            close: '.close'
        }
    })
;

emailTemplatePreviewButtons.forEach((emailPreviewTemplateButton) => {
    emailPreviewTemplateButton.addEventListener('click', (event) => {
        event.preventDefault();
        emailPreviewTemplateButton.classList.add('loading');

        const template = document.querySelector('#bitbag_sylius_mail_template_plugin_template_email_type').value;
        const styleCss = document.querySelector('#bitbag_sylius_mail_template_plugin_template_email_styleCss').value;
        const name = emailPreviewTemplateButton.parentElement.querySelector('[name$="[name]"]').value;
        const subject = emailPreviewTemplateButton.parentElement.querySelector('[name$="[subject]"]').value;
        const content = emailPreviewTemplateButton.parentElement.querySelector('[name$="[content]"]').value;
        const previewValidationErrorContainer = emailPreviewTemplateButton.parentElement.querySelector('.mail-preview-validation-errors');

        axios({
            method: 'post',
            url: '/admin/mail-template/preview',
            data: {
                template,
                subject,
                name,
                content,
                styleCss
            }
        }).then((response) => {
            mailPreviewModal.modal('show');
            previewValidationErrorContainer.innerHTML = '';
            document.querySelector('.mail-preview.modal > .content').innerHTML = response.data;
        }).catch((error) => {
            const ul = document.createElement('ul');
            ul.classList.add('list');

            const li = document.createElement('li');
            li.innerText = error.response.data.message;

            ul.append(li);
            previewValidationErrorContainer.innerHTML = '';
            previewValidationErrorContainer.append(ul);
        }).finally(() => {
            document.querySelector('.mail-preview.modal').classList.remove('hidden');
            emailPreviewTemplateButton.classList.remove('loading');
        });
    });
});
