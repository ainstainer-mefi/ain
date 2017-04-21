import { Component, OnInit,  OnDestroy} from '@angular/core';
import {
    UserService
} from '../_shared/services/index';

import {  trigger,
    state,
    style,
    transition,
    animate,
    keyframes} from '@angular/animations';

@Component({
    moduleId: module.id,
    selector: 'app-pages',
    templateUrl: 'pages.component.html',
    styleUrls: ['./pages.component.scss'],
    animations: [
        trigger('focusPanel', [
            state('inactive', style({
                transform: 'scale(1)'
            })),
            state('active', style({
                transform: 'scale(1.1)'
            })),
            transition('inactive => active', animate('500ms ease-in')),
            transition('active => inactive', animate('500ms ease-out'))
        ]),
    ]
})
export class PagesComponent {
    state = 'inactive';
    currentUser;

    constructor(private userService: UserService) {
        //console.log('PagesComponent');
        this.currentUser = userService.getCurrentUser();
        console.log( this.currentUser);
    }

    toggleMove() {
        this.state = (this.state === 'inactive' ? 'active' : 'inactive');
    }


}
