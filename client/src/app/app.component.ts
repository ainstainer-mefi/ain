import {Component, OnInit, AfterViewInit, VERSION} from '@angular/core';
import {DomSanitizer} from '@angular/platform-browser';
import {MdIconRegistry} from '@angular/material';
//import { ConfigService } from './_shared/services/index';
import { AngularFireDatabase, FirebaseListObservable, FirebaseObjectObservable } from 'angularfire2/database';
import {TranslateService} from '@ngx-translate/core';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})

export class AppComponent implements OnInit, AfterViewInit {
    items: FirebaseListObservable<any[]>;
    //item: FirebaseObjectObservable<any>;

    constructor(
        private db: AngularFireDatabase,
        private _iconRegistry: MdIconRegistry,
        private _domSanitizer: DomSanitizer,
        private _translateService: TranslateService
        //private config: ConfigService
    ) {
        let jiraIconUrl = this._domSanitizer.bypassSecurityTrustResourceUrl('assets/icons/jira3.svg');
        this._iconRegistry.addSvgIconInNamespace('assets', 'jira', jiraIconUrl);

        //const itemObservable = db.object('/item');
        //itemObservable.set({ name: 'new name2!'});
        //this.items = db.list('/item');

        // Set fallback language
        this._translateService.setDefaultLang('en');

        // Supported languages
        this._translateService.addLangs(['en', 'ru']);

        // Get selected language and load it
        this._translateService.use(_translateService.getBrowserLang());
        //this._translateService.use('ru');


    }

    ngOnInit() {
        console.log(VERSION.full);
        /*this.items.  subscribe((data) => {
            console.log(data);
        });*/

    }

    ngAfterViewInit() {

        /*gapi.load('auth2', () => {
         gapi.auth2.init({
         client_id: this.config.getGoogleClientId(),
         scope: this.config.getGoogleScope(),
         fetch_basic_profile: true,
         });
         });*/

    }

}
