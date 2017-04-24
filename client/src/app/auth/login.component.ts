import {Component, OnInit, NgZone, AfterViewInit} from '@angular/core';
// import {Router} from '@angular/router';
// import {FormGroup, FormControl, Validators} from '@angular/forms';
import {AuthenticationService, ConfigService, SnackbarService} from '../_shared/services/index';


@Component({
    moduleId: module.id,
    templateUrl: 'login.component.html',
    styleUrls: ['login.component.scss'],

})
export class LoginComponent implements OnInit, AfterViewInit {

    //myForm: FormGroup;
    model: any = {};
    private redirectUrl;

    constructor(//private router: Router,
                private auth: AuthenticationService,
                private alert: SnackbarService,
                //private _zone: NgZone,
                private config: ConfigService) {

        this.redirectUrl = window.location.protocol + '//' + window.location.host;
        console.log('LoginComponent');

        /*this.myForm = new FormGroup({

         'email': new FormControl('', [
         Validators.required,
         Validators.pattern('^\s*[a-zA-Z0-9.-_]+@ainstainer.de')
         ]),
         'password': new FormControl('', [
         Validators.required,
         Validators.minLength(8)
         ]),

         });*/

    }

    ngOnInit() {
        this.auth.logout();
    }

    ngAfterViewInit() {

        gapi.load('auth2', () => {
            gapi.auth2.init({
                client_id: this.config.getGoogleClientId(),
                scope: this.config.getGoogleScope(),
                fetch_basic_profile: true,
            });
        });
    }

    grand() {

        const params = {scope: this.config.getGoogleScope()};
        gapi.auth2.getAuthInstance()
            .grantOfflineAccess(params)
            .then((resp) => {
                    this.onGrantOfflineSuccess(resp);
                },
                (error) => {
                    this.onGoogleLoginError(error);
                });
    }

    onGrantOfflineSuccess(resp) {
        const auth_code = resp.code;

        console.log(resp);


        this.auth.loginWithGoogleCode(auth_code)
            .subscribe(
                (user) => {
                    console.log(user);
                    window.location.href = this.redirectUrl;
                    // this.router.navigate(['']);
                },
                (error: any) => {
                    console.warn('Server connection problem');
                    console.dir(error);
                });
    }


    onGoogleLoginError(e) {
        console.log('onGoogleLoginError');
        console.log(e.error);
        this.alert.show(e.error);
    }

}
