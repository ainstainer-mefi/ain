import 'hammerjs';
import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from '@angular/http';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {Angular2FontawesomeModule} from 'angular2-fontawesome/angular2-fontawesome';
import {
    CovalentCommonModule,
    CovalentMessageModule,
    CovalentExpansionPanelModule,
    CovalentNotificationsModule
} from '@covalent/core';


import {
    MdSnackBar,
    MdSidenavModule,
    MdInputModule,
    MdToolbarModule,
    MdMenuModule,
    MdIconModule,
    MdIconRegistry,
    MdCardModule,
    MdButtonModule,
    MdSnackBarModule,
    MdTabsModule,
    MdProgressSpinnerModule,
    MdProgressBarModule,
    MdButtonToggleModule,
    MdListModule,
} from '@angular/material';

// import {
//      CollapseModule,
//     BsDropdownModule,
//      CarouselModule,
//     ModalModule
// } from 'ngx-bootstrap';

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
import { AppComponent } from './app.component';
import { LoginComponent } from './auth/index';
import {
    PagesComponent,
    NotFoundPageComponent,
    HomePageComponent,
    DocsPageComponent,
    ProfilePageComponent,
    CalendarPageComponent,
} from './pages/index';

export const PAGE_COMPONENTS = [
    ProfilePageComponent,
    NotFoundPageComponent,
    HomePageComponent,
    DocsPageComponent,
    CalendarPageComponent,
    PagesComponent
];

/*Shared components*/
import {
    SidebarComponent,
    ProgressBarComponent,
    SpinnerComponent,
    UserMenuComponent,
    CalendarComponent,
    AvatarComponent,
    PageWrapperComponent
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
import { ProxyPipe } from './_shared/pipes/proxy.pipe';

/*directives*/
import { BgColorDirective} from './_shared/directives/BgColorDirective';


@NgModule({
    imports: [
        routing,
        CovalentCommonModule,
        CovalentMessageModule,
        CovalentExpansionPanelModule,
        CovalentNotificationsModule,
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
        MdIconModule,
        MdCardModule,
        MdButtonModule,
        MdListModule,
        MdProgressSpinnerModule,
        MdProgressBarModule,
        MdButtonToggleModule
    ],
    declarations: [
        AppComponent,
        LoginComponent,
        PAGE_COMPONENTS,
        SHARED_COMPONENTS,
        ProxyPipe,
        BgColorDirective,
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
