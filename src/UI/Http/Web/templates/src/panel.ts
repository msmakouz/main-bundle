export class Panel {
    constructor() {
        this.onMenuItemHover();
    };

    onMenuItemHover() {
        document.querySelector('.zx-sub-items').addEventListener('mouseover', function () {
            document.querySelector('.zx-sub-items').classList.add('active');
        });
        document.querySelector('.zx-sub-items').addEventListener('mouseout', function () {
            document.querySelector('.zx-sub-items').classList.remove('active');
        });
    }
}