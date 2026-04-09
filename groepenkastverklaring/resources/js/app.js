import './bootstrap';

import Alpine from 'alpinejs';
import tagDragManager from './tag-drag-manager';

window.Alpine = Alpine;

Alpine.data('tagDragManager', tagDragManager);

Alpine.start();
