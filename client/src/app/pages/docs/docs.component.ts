import {Component, OnInit} from '@angular/core';
import {UserDocsService,ConfigService} from '../../_shared/services/index';
//import {SpinnerComponent} from '../../_shared/components/index';


@Component({
    selector: 'app-docs',
    templateUrl: './docs.component.html',
    styleUrls: ['./docs.component.scss'],
    providers: [UserDocsService]
})
export class DocsComponent implements OnInit {
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
