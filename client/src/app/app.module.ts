import 'hammerjs';
import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from '@angular/http';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {Angular2FontawesomeModule} from 'angular2-fontawesome/angular2-fontawesome';
import { CovalentCoreModule } from '@covalent/core';


import {
    MdSnackBar,
    MdSidenavModule,
    MdInputModule,
    MdToolbarModule,
    MdMenuModule,
    MdIconModule,
    MdCardModule,
    MdButtonModule,
    MdSnackBarModule,
    MdTabsModule,
    MdProgressSpinnerModule,
    MdProgressBarModule,
    MdButtonToggleModule
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
    CalendarPageComponent
} from './pages/index';

export const PAGE_COMPONENTS = [
    ProfilePageComponent,
    NotFoundPageComponent,
    HomePageComponent,
    DocsPageComponent,
    CalendarPageComponent,
    PagesComponent
];

import {
    SidebarComponent,
    ProgressBarComponent,
    SpinnerComponent,
    UserMenuComponent,
    CalendarComponent,
    AvatarComponent,
} from './_shared/components/index';

/*pipes*/
import { ProxyPipe } from './_shared/pipes/proxy.pipe';



@NgModule({
    imports: [
        routing,
        CovalentCoreModule,
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
        MdProgressSpinnerModule,
        MdProgressBarModule,
        MdButtonToggleModule
    ],
    declarations: [
        AppComponent,
        LoginComponent,
        PAGE_COMPONENTS,
        SidebarComponent,
        UserMenuComponent,
        SpinnerComponent,
        ProxyPipe,
        ProgressBarComponent,
        CalendarComponent,
        AvatarComponent
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
