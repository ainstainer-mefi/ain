import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpModule} from '@angular/http';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
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
    MdProgressBarModule
} from '@angular/material';
import {
    // CollapseModule,
    BsDropdownModule,
    CarouselModule,
} from 'ngx-bootstrap';
import {Angular2FontawesomeModule} from 'angular2-fontawesome/angular2-fontawesome';
import 'hammerjs';

import {routing} from './app.routing';


/*services**/
import {
    ConfigService,
    AuthenticationService,
    SnackbarService,
    ApiGatewayService,
    UserService
} from './_shared/services/index';
import {AuthGuard} from './_guards/index';

/*components**/
import {AppComponent} from './app.component';
import {PagesComponent, NotFoundComponent, HomeComponent, DocsComponent} from './pages/index';
import {LoginComponent} from './auth/index';
import {SidebarComponent} from './_shared/components/index';
import {UserMenuComponent} from './_shared/components/user-menu/user-menu.component';
import { SpinnerComponent } from './_shared/components/spinner/spinner.component';
import { ProxyPipe } from './_shared/pipes/proxy.pipe';

@NgModule({
    imports: [
        routing,
        BrowserModule,
        FormsModule,
        ReactiveFormsModule,
        HttpModule,
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
        // CollapseModule.forRoot(),
        BsDropdownModule.forRoot(),
        CarouselModule.forRoot()
    ],
    declarations: [
        AppComponent,
        NotFoundComponent,
        PagesComponent,
        HomeComponent,
        LoginComponent,
        SidebarComponent,
        DocsComponent,
        UserMenuComponent,
        SpinnerComponent,
        ProxyPipe,
    ],
    providers: [
        AuthGuard,
        ConfigService,
        ApiGatewayService,
        AuthenticationService,
        MdSnackBar,
        SnackbarService,
        UserService,

    ],
    bootstrap: [AppComponent]
})
export class AppModule {
}
