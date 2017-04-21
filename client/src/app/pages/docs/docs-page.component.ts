import {Component, OnInit} from '@angular/core';
import {UserDocsService,ConfigService} from '../../_shared/services/index';

@Component({
    selector: 'app-docs',
    templateUrl: './docs-page.component.html',
    styleUrls: ['./docs-page.component.scss'],
    providers: [UserDocsService]
})
export class DocsPageComponent implements OnInit {

    public isRequesting: boolean;
    public items: Array<any>;
    public apiUrl;

    constructor(private userDocs: UserDocsService, private config: ConfigService) {
        this.isRequesting = true;
        this.apiUrl = config.getConfig('apiUrl')
    }

    ngOnInit() {
        this.loadDocs();
    }


    private loadDocs() {

        this.userDocs.getDocs()
            .subscribe(
                (data) => {
                    this.isRequesting = false;
                    this.items = data;
                    console.log(data);
                },
                (error: any) => {
                    this.isRequesting = false;
                    console.warn('Server connection problem');
                    console.dir(error);
                });
    }
}
