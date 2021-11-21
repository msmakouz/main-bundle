import 'simple-line-icons/dist/styles/simple-line-icons.scss';
import './css/switch.less';
import './css/modal.scss';
import './css/editor.scss';
import './css/panel.scss';

import { Panel } from './panel'
import { VisualEditor } from './visualEditor';
import { Modal } from './modal';

document.addEventListener('DOMContentLoaded', function(event) {
    new Panel();
    new VisualEditor(new Modal());
});