import { Component} from '@angular/core';

@Component({
    selector: 'app-not-found',
    template: `<h3 style="text-align: center;">Страница не найдена</h3>`
})
export class NotFoundComponent {
    constructor() {
        console.log('NotFoundComponent');
    }
}
