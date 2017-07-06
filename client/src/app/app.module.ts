import 'hammerjs';
import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule, Http} from '@angular/http';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {Angular2FontawesomeModule} from 'angular2-fontawesome/angular2-fontawesome';
import { environment } from '../environments/environment';

import {
    CovalentCommonModule,
    CovalentExpansionPanelModule,
    CovalentNotificationsModule
} from '@covalent/core';

import {TranslateModule, TranslateLoader} from '@ngx-translate/core';
import {TranslateHttpLoader} from '@ngx-translate/http-loader';

import {
    MdSnackBar,
    MdSidenavModule,
    MdInputModule,
    MdSelectModule,
    MdToolbarModule,
    MdMenuModule,
    MdIconModule,
    MdCardModule,
    MdButtonModule,
    MdSnackBarModule,
    MdTabsModule,
    MdProgressSpinnerModule,
    MdProgressBarModule,
    MdButtonToggleModule,
    MdListModule,
    MdDialogModule,
    MdDatepickerModule,
    MdNativeDateModule,
} from '@angular/material';


import {routing} from './app.routing';

/*services**/
import {
    ConfigService,
    AuthenticationService,
    SnackbarService,
    ApiGatewayService,
    UserService,
    PreloaderService
} from './_shared/services/index';
import {AuthGuard} from './_guards/index';

/*components**/
import {AppComponent} from './app.component';
import {JiraAccountComponent} from './pages/profile/jira-account.component';
import {LoginComponent} from './auth/index';
import {
    PagesComponent,
    NotFoundPageComponent,
    HomePageComponent,
    DocsPageComponent,
    ProfilePageComponent,
    CalendarPageComponent,
    MembersPageComponent,
} from './pages/index';


export const PAGE_COMPONENTS = [
    ProfilePageComponent,
    NotFoundPageComponent,
    HomePageComponent,
    DocsPageComponent,
    CalendarPageComponent,
    PagesComponent,
    MembersPageComponent
];

/*Shared components*/
import {
    SidebarComponent,
    ProgressBarComponent,
    SpinnerComponent,
    UserMenuComponent,
    CalendarComponent,
    AvatarComponent,
    PageWrapperComponent,
    //ExampleDialog
} from './_shared/components/index';
export const SHARED_COMPONENTS = [
    SidebarComponent,
    ProgressBarComponent,
    SpinnerComponent,
    UserMenuComponent,
    CalendarComponent,
    AvatarComponent,
    PageWrapperComponent
];


/*pipes*/
import {ProxyPipe} from './_shared/pipes/proxy.pipe';

/*directives*/
import {BgColorDirective} from './_shared/directives/BgColorDirective';


import {AngularFireModule} from 'angularfire2';
import {AngularFireDatabaseModule, AngularFireDatabase, FirebaseListObservable} from 'angularfire2/database';
import {AngularFireAuthModule, AngularFireAuth} from 'angularfire2/auth';
import {MD_DATE_FORMATS} from "@angular/material/typings/core/datetime/date-formats";
// Do not import from 'firebase' as you'd lose the tree shaking benefits
//import * as firebase from 'firebase/app';

export function HttpLoaderFactory(http: Http) {
    return new TranslateHttpLoader(http);
}

@NgModule({
    // entryComponents: [
    //     ExampleDialog
    // ],
    imports: [
        AngularFireModule.initializeApp(environment.firebase),
        AngularFireDatabaseModule,
        AngularFireAuthModule,
        routing,
        CovalentCommonModule,
        CovalentExpansionPanelModule,
        CovalentNotificationsModule,
        TranslateModule.forRoot({
            loader: {provide: TranslateLoader, useFactory: HttpLoaderFactory, deps: [Http]}
        }),
        BrowserModule,
        HttpModule,
        FormsModule,
        ReactiveFormsModule,
        BrowserAnimationsModule,
        Angular2FontawesomeModule,
        MdToolbarModule,
        MdSnackBarModule,
        MdTabsModule,
        MdSidenavModule,
        MdMenuModule,
        MdInputModule,
        MdSelectModule,
        MdIconModule,
        MdCardModule,
        MdButtonModule,
        MdListModule,
        MdProgressSpinnerModule,
        MdProgressBarModule,
        MdButtonToggleModule,
        MdDialogModule,
        MdDatepickerModule,
        MdNativeDateModule

    ],
    declarations: [
        AppComponent,
        LoginComponent,
        JiraAccountComponent,
        PAGE_COMPONENTS,
        SHARED_COMPONENTS,
        ProxyPipe,
        BgColorDirective,
        //ExampleDialog
    ],
    providers: [
        AuthGuard,
        ConfigService,
        ApiGatewayService,
        AuthenticationService,
        MdSnackBar,
        SnackbarService,
        UserService,
        PreloaderService
    ],
    bootstrap: [AppComponent]
})
export class AppModule {
}
