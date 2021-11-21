import MicroModal from 'micromodal';
import * as ClassicEditor from './editor/ckeditor'
import './editor/ru'

export class Modal {
    public submitBtn = document.querySelector('.micromodal-submit');
    public editor;

    private modalId = 'admin-modal';
    private contentElement = document.querySelector('.admin-panel-modal-content');
    private titleElement = document.querySelector('.admin-panel-modal-title');

    private modalErrorId = 'admin-modal-error';
    private contentErrorElement = document.querySelector('.admin-panel-error-content .alert-danger');

    public show(content: string, title: string): void {
        this.contentElement.innerHTML = content;
        this.titleElement.innerHTML = title;

        let editorElement = document.querySelector('.admin-panel-modal-content .cke-editor');

        if(editorElement) {
            ClassicEditor.create(editorElement, {language: 'ru'})
                .then(newEditor => {this.editor = newEditor;})
                .catch(error => console.error( error ));
        }

        MicroModal.show(this.modalId, {disableScroll: true});
    }

    public showError(error: string): void {
        this.contentErrorElement.innerHTML = error;
        MicroModal.show(this.modalErrorId, {disableScroll: true});
    }

    public close(): void {
        this.titleElement.innerHTML = '';
        this.contentElement.innerHTML = '';
        MicroModal.close(this.modalId);
    }
}