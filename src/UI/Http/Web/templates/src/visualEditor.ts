import axios from 'axios';
import * as config from './visualEditorConfig';
import { Modal } from "./modal";
import * as ClassicEditor from './editor/ckeditor'
import './editor/ru'

export class VisualEditor {

    private modal: Modal;
    private editorToggleBtn = document.querySelector('input[name="zx-visual-editor');
    private contentEditableElements = document.querySelectorAll('[contenteditable=true]');

    constructor(modal: Modal) {
        this.modal = modal;

        this.editorToggleBtn.addEventListener('change', () => this.onVisualEditorToggle());
        // Быстрое редактирование
        this.contentEditableElements.forEach((element) => element.addEventListener('blur', () => this.fastEditElement(element)));
        // Наведение на редактируемый блок
        this.onHoverEditedBlock();
        // Редактирование
        document.querySelectorAll('.visual-editor-edit').forEach((element) => element.addEventListener('click', () => this.showEditModal(element)));

        this.editorToggleBtn.checked ?
            this.modal.submitBtn.addEventListener('click', () => this.editElement()) :
            this.modal.submitBtn.removeEventListener('click', () => this.editElement())
    }

    private onVisualEditorToggle(): void {
        axios.post(this.editorToggleBtn.checked ? config.enableRoute : config.disableRoute,
            {url: window.location.href}, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then((response) => {
                if(response.data.success) {
                    window.location.reload(true);
                } else {
                    this.editorToggleBtn.checked = false;
                    this.modal.showError(response.data.error);
                }
            })
            .catch((error) => console.log(error));

        this.editorToggleBtn.checked ?
            this.modal.submitBtn.addEventListener('click', () => this.editElement()) :
            this.modal.submitBtn.removeEventListener('click', () => this.editElement())
    }

    private onHoverEditedBlock(): void {
        document.querySelectorAll('.visual-editor-content').forEach((element) => element.addEventListener('mouseover', () => {
            element.previousElementSibling.style.display = 'block';
            element.style.border = 'solid 1px #777f8c';
        }));
        document.querySelectorAll('.visual-editor-content').forEach((element) => element.addEventListener('mouseout', () => {
            element.previousElementSibling.style.display = 'none';
            element.style.border = 'none';
        }));
        document.querySelectorAll('.visual-editor-actions-block').forEach((element) => element.addEventListener('mouseover', () => {
            element.nextElementSibling.style.border = 'solid 1px #777f8c';
            element.style.display = 'block';
        }));
        document.querySelectorAll('.visual-editor-actions-block').forEach((element) => element.addEventListener('mouseout', () => {
            element.nextElementSibling.style.border = 'none';
            element.style.display = 'none';
        }));
    }

    private showEditModal(link): void {
        const element = document.querySelector(`.visual-editor-content[data-code="${link.getAttribute('data-code')}"]`);
        const data = {
            entity: element.getAttribute('data-class'),
            code: element.getAttribute('data-code'),
            form: element.getAttribute('data-form')
        };

        element.classList.add('element-edited');

        axios.post(config.editRoute, data, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then((response) => response.data.success ? this.modal.show(response.data.form, response.data.title) : this.modal.showError(response.data.error))
            .catch((error) => console.log(error));
    }

    private fastEditElement(element): void {
        const data = {
            entity: element.getAttribute('data-class'),
            code: element.getAttribute('data-code'),
            content: element.innerHTML
        };

        axios.post(config.fastEditRoute, data, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then((response) => {
                if(response.data.success === false) {
                    this.modal.showError(response.data.error);
                }
            })
            .catch((error) => console.log(error));
    }

    private editElement(): void {
        let editorElement = document.querySelector('.admin-panel-modal-content .cke-editor');

        if(editorElement) {
            document.querySelector('.admin-panel-modal-content .cke-editor').innerHTML = this.modal.editor.getData();
        }

        const form = document.querySelector('form[name="visual_edit_form"]');
        const formData = new FormData(form);
        const editedElement = document.querySelector('.element-edited');

        formData.append('entity', editedElement.getAttribute('data-class'));
        formData.append('code', editedElement.getAttribute('data-code'));
        formData.append('form', editedElement.getAttribute('data-form'));

        axios.post(config.editRoute, formData , {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then((response) => {
                this.modal.close();
                if(response.data.success) {
                    editedElement.innerHTML = response.data.content;
                    editedElement.classList.remove('element-edited');
                } else {
                    this.modal.showError(response.data.error);
                }
            })
            .catch((error) => console.log(error));
    }
}