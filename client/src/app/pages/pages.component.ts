import { Component, OnInit,  OnDestroy} from '@angular/core';
import { TdMediaService } from '@covalent/core';
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
    /*animations: [
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
    ]*/
})
export class PagesComponent {
    //state = 'inactive';
    currentUser;

    constructor(private userService: UserService, public media: TdMediaService) {
        this.currentUser = userService.getCurrentUser();
    }

    routes: Object[] = [{
        title: 'Dashboard',
        route: '/',
        icon: 'dashboard',
    }, {
        title: 'Product Dashboard',
        route: '/product',
        icon: 'view_quilt',
    }, {
        title: 'Product Logs',
        route: '/logs',
        icon: 'receipt',
    }, {
        title: 'Manage Users',
        route: '/users',
        icon: 'people',
    }, {
        title: 'Covalent Templates',
        route: '/templates',
        icon: 'view_module',
    },
    ];


    ngAfterViewInit(): void {
        // broadcast to all listener observables when loading the page
        this.media.broadcast();
    }

    /*toggleMove() {
        this.state = (this.state === 'inactive' ? 'active' : 'inactive');
    }*/


}
