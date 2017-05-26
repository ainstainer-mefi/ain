/// <reference path="../../../../node_modules/@types/gapi/index.d.ts" />
/// <reference path="../../../../node_modules/@types/gapi.auth2/index.d.ts" />
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
//import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/catch';

import {ApiGatewayService} from './api-gateway.service';
import {UserService, User} from './user/user.service';
//import {ConfigService} from './config.service';


@Injectable()
export class AuthenticationService {

    private url:string = '/api/authentication';
    private localStorageTokenKey:string = 'apiToken';

    //isLoginSubject = new BehaviorSubject<boolean>(this.hasUser());

    constructor(
        private apiGatewayService: ApiGatewayService,
        //private configService: ConfigService,
        private userService: UserService
    ) {
    }

    /**
     *
     */
    logout() {
        //this.isLoginSubject.next(false);
        this.userService.resetCurrentUser();
        localStorage.removeItem(this.localStorageTokenKey);
    }


    /**
     *
     * @param auth_code
     * @returns {Observable<R>}
     */
    loginWithGoogleCode(auth_code): Observable<User> {

        const data = {auth_code: auth_code};
        return this.apiGatewayService.get(this.url, data, false)
            .map((response: any) => {
                const user =  this.userService.createUserModel(response);
                this.userService.setCurrentUser(user);
                localStorage.setItem(this.localStorageTokenKey, response.apiToken);
                return user;
            });
    }


    /**
     * if we have user is loggedIn
     * @returns {boolean}
     */
    /*private hasUser(): boolean {

        return !!localStorage.getItem('currentUser');
    }*/

    /**
     *
     * @returns {Observable<T>}
     */
    /*isLoggedIn(): Observable<boolean> {
        return this.isLoginSubject.asObservable();
    }*/

}
