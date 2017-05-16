import {Component, OnInit} from '@angular/core';
import {UserDocsService, PreloaderService} from '../../_shared/services/index';
import {  trigger,
    state,
    style,
    transition,
    animate,
    keyframes, group} from '@angular/animations';

@Component({
    selector: 'app-docs',
    templateUrl: './docs-page.component.html',
    styleUrls: ['./docs-page.component.scss'],
    providers: [UserDocsService],
    animations: [
        trigger('itemAnim', [
            transition(':enter', [
                style({transform: 'translateX(-100%)'}),
                animate(400)
            ])
        ])
    ]
})
export class DocsPageComponent implements OnInit {

    public isRequesting: boolean = false;
    public items: Array<any> = [];


    constructor(private _userDocs: UserDocsService, private _preloaderService: PreloaderService) {
    }

    ngOnInit() {
        this.loadDocs();
    }

    private loadDocs() {
        this.isRequesting = true;
        this._preloaderService.register();

        this._userDocs.getDocs()
            .subscribe(
                (data) => {
                    this.items = data;
                    console.log(this.items);
                    this.isRequesting = false;
                    this._preloaderService.resolve();
                },
                (error: any) => {
                    this._preloaderService.resolve();
                    this.isRequesting = false;
                    console.warn('Server connection problem');
                    console.dir(error);
                });
    }
}