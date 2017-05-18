import {Injectable} from '@angular/core';
import {ApiGatewayService} from '../api-gateway.service';

export class User {
    name: string;
    email: string;
    picture: string;
    family_name: string;
    given_name: string;
}

@Injectable()
export class UserService {

    private url = '/api/user-profile';
    private currentUser: User;

    constructor(private apiGatewayService: ApiGatewayService) {
        if (!this.currentUser && localStorage.getItem('currentUser')) {
            this.currentUser = this.createUserModel(JSON.parse(localStorage.getItem('currentUser')));
        }
    }

    public setCurrentUser(user: User) {
        this.currentUser = user;
    }

    public getCurrentUser(): User {
        return this.currentUser;
    }

    public createUserModel(data: any): User {
        let user = new User();
        user.name = data.name;
        user.email = data.email;
        user.picture = data.picture;
        user.family_name = data.family_name;
        user.given_name = data.given_name;
        return user;
    }


    getProfile() {
        return this.apiGatewayService.get(this.url, {})
            .map((response: any) => {
                return response;
            });
    }


    bindJiraAccount(account) {
        let params = {'id': account.id};
        return this.apiGatewayService.post(this.url, false, params, false)
            .map((response: any) => {
                return response;
            });
    }
}
