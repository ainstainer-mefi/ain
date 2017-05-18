import { Component,  Input, OnInit } from '@angular/core';
import {PreloaderService} from '../../services/index';

@Component({
    selector: 'app-page-wrapper',
    templateUrl: './page-wrapper.component.html',
    styleUrls: ['./page-wrapper.component.scss']
})
export class PageWrapperComponent implements OnInit {

    @Input() title: string = 'Page title';

    constructor(){}

    ngOnInit() {

    }


}