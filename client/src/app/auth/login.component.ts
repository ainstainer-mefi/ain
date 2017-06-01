import { Component, OnInit, NgZone, AfterViewInit, OnDestroy } from '@angular/core';
import { Router} from '@angular/router';

// import {FormGroup, FormControl, Validators} from '@angular/forms';
import { AuthenticationService, ConfigService, SnackbarService } from '../_shared/services/index';
import { AngularFireAuth } from 'angularfire2/auth';
// Do not import from 'firebase' as you'd lose the tree shaking benefits
import * as firebase from 'firebase/app';

@Component({
    moduleId: module.id,
    templateUrl: 'login.component.html',
    styleUrls: ['login.component.scss']
})
export class LoginComponent implements OnInit, AfterViewInit {


    //myForm: FormGroup;
    private redirectUrl;

    constructor(//private router: Router,
                private auth: AuthenticationService,
                private alert: SnackbarService,
                private afAuth: AngularFireAuth,
                //private _zone: NgZone,
                private router: Router,
                private config: ConfigService) {

        this.redirectUrl = window.location.protocol + '//' + window.location.host;

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

    /*login() {
        var provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('profile');
        provider.addScope('https://www.googleapis.com/auth/gmail.readonly');
        provider.setCustomParameters({
            'login_hint': 'user@example.com',
            'client_id': '615988777624-u4fnno6qel9elen40q0snif7tfqofa2s.apps.googleusercontent.com',
        });
        this.afAuth.auth.signInWithPopup(provider).then(function(result) {
            // This gives you a Google Access Token.
            var token = result.credential.accessToken;
            // The signed-in user info.
            var user = result.user;
            console.log(user);
        });
    }

    logout() {
        this.afAuth.auth.signOut().then(function(result) {

            console.log(result);
        });
    }*/

    ngAfterViewInit() {

        gapi.load('auth2', () => {
            gapi.auth2.init({
                client_id: this.config.getGoogleClientId(),
                scope: this.config.getGoogleScope(),
                fetch_basic_profile: true,
            }).then(() => {
                const auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut();
            },() => {
                console.dir('Error signOut');
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
                    //this.router.navigate(['']);
                },
                (error: any) => {
                    console.warn('Server connection problem');
                    console.dir(error);
                });
    }


    onGoogleLoginError(e) {
        console.log('onGoogleLoginError');
        console.log(e);
        this.alert.show(e.error);
    }



}
