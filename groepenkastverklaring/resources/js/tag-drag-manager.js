export default function tagDragManager(initialGroepen) {
    return {
        groepen: initialGroepen,
        dragging: null,
        ghostEl: null,
        indicatorEl: null,
        hoverGroep: null,
        dropGroep: null,
        dropIndex: null,

        init() {
            this.boundMouseMove = this.onMouseMove.bind(this);
            this.boundMouseUp = this.onMouseUp.bind(this);
            this.boundTouchMove = this.onTouchMove.bind(this);
            this.boundTouchEnd = this.onTouchEnd.bind(this);

            this.indicatorEl = document.createElement('div');
            this.indicatorEl.style.cssText = 'position:fixed;width:2px;background:#3b82f6;border-radius:1px;z-index:9998;display:none;pointer-events:none;';
            document.body.appendChild(this.indicatorEl);
        },

        getXY(e) {
            if (e.touches && e.touches.length) return { x: e.touches[0].clientX, y: e.touches[0].clientY };
            if (e.changedTouches && e.changedTouches.length) return { x: e.changedTouches[0].clientX, y: e.changedTouches[0].clientY };
            return { x: e.clientX, y: e.clientY };
        },

        startDrag(e, groepId, tagIndex, tag) {
            this.dragging = { fromGroep: groepId, tagIndex: tagIndex, tag: tag };
            document.body.classList.add('dragging');

            const { x, y } = this.getXY(e);
            this.ghostEl = document.createElement('span');
            this.ghostEl.className = 'tag-ghost inline-flex items-center bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded';
            this.ghostEl.textContent = tag;
            this.ghostEl.style.left = (x + 10) + 'px';
            this.ghostEl.style.top = (y + 10) + 'px';
            document.body.appendChild(this.ghostEl);

            if (e.type === 'touchstart') {
                document.addEventListener('touchmove', this.boundTouchMove, { passive: false });
                document.addEventListener('touchend', this.boundTouchEnd);
            } else {
                document.addEventListener('mousemove', this.boundMouseMove);
                document.addEventListener('mouseup', this.boundMouseUp);
            }
        },

        computeDropPosition(x, y) {
            if (!this.dragging) return;

            const el = document.elementFromPoint(x, y);
            if (!el) { this.clearDrop(); return; }

            const cell = el.closest('[data-groep-id]');
            if (!cell) { this.clearDrop(); return; }

            const groepId = parseInt(cell.dataset.groepId);
            this.hoverGroep = groepId;

            const tagEls = cell.querySelectorAll('[data-tag]');
            if (tagEls.length === 0) {
                this.setDrop(groepId, 0, cell);
                return;
            }

            let insertIndex = tagEls.length;
            for (let i = 0; i < tagEls.length; i++) {
                const rect = tagEls[i].getBoundingClientRect();
                if (y < rect.top) { insertIndex = i; break; }
                if (y <= rect.bottom) {
                    if (x < rect.left + rect.width / 2) { insertIndex = i; break; }
                }
            }

            if (groepId === this.dragging.fromGroep &&
                (insertIndex === this.dragging.tagIndex || insertIndex === this.dragging.tagIndex + 1)) {
                this.clearDrop();
                return;
            }

            this.setDrop(groepId, insertIndex, cell);
        },

        setDrop(groepId, index, cell) {
            this.dropGroep = groepId;
            this.dropIndex = index;

            const tagEls = cell.querySelectorAll('[data-tag]');
            if (tagEls.length === 0) {
                const cellRect = cell.querySelector('div').getBoundingClientRect();
                this.indicatorEl.style.left = (cellRect.left + 4) + 'px';
                this.indicatorEl.style.top = (cellRect.top + 4) + 'px';
                this.indicatorEl.style.height = (cellRect.height - 8) + 'px';
            } else if (index < tagEls.length) {
                const rect = tagEls[index].getBoundingClientRect();
                this.indicatorEl.style.left = (rect.left - 2) + 'px';
                this.indicatorEl.style.top = rect.top + 'px';
                this.indicatorEl.style.height = rect.height + 'px';
            } else {
                const rect = tagEls[tagEls.length - 1].getBoundingClientRect();
                this.indicatorEl.style.left = (rect.right + 2) + 'px';
                this.indicatorEl.style.top = rect.top + 'px';
                this.indicatorEl.style.height = rect.height + 'px';
            }
            this.indicatorEl.style.display = 'block';
        },

        clearDrop() {
            this.dropGroep = null;
            this.dropIndex = null;
            this.indicatorEl.style.display = 'none';
        },

        onMouseMove(e) {
            if (this.ghostEl) {
                this.ghostEl.style.left = (e.clientX + 10) + 'px';
                this.ghostEl.style.top = (e.clientY + 10) + 'px';
            }
            this.computeDropPosition(e.clientX, e.clientY);
        },

        onTouchMove(e) {
            e.preventDefault();
            const { x, y } = this.getXY(e);
            if (this.ghostEl) {
                this.ghostEl.style.left = (x + 10) + 'px';
                this.ghostEl.style.top = (y + 10) + 'px';
            }
            this.computeDropPosition(x, y);
        },

        finishDrag() {
            if (this.ghostEl) { this.ghostEl.remove(); this.ghostEl = null; }
            this.indicatorEl.style.display = 'none';

            if (this.dragging && this.dropGroep !== null && this.dropIndex !== null) {
                const { tag, fromGroep, tagIndex: fromIndex } = this.dragging;
                const toGroep = this.dropGroep;
                let toIndex = this.dropIndex;

                this.groepen[fromGroep].tags.splice(fromIndex, 1);
                if (fromGroep === toGroep && fromIndex < toIndex) toIndex--;
                this.groepen[toGroep].tags.splice(toIndex, 0, tag);
            }

            document.body.classList.remove('dragging');
            this.dragging = null;
            this.dropGroep = null;
            this.dropIndex = null;
            this.hoverGroep = null;
        },

        onMouseUp(e) {
            document.removeEventListener('mousemove', this.boundMouseMove);
            document.removeEventListener('mouseup', this.boundMouseUp);
            this.finishDrag();
        },

        onTouchEnd(e) {
            document.removeEventListener('touchmove', this.boundTouchMove);
            document.removeEventListener('touchend', this.boundTouchEnd);
            this.finishDrag();
        }
    }
}
