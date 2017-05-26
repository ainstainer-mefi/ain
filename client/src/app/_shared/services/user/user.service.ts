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
    private localStorageUserKey: string = 'currentUser';

    constructor(private apiGatewayService: ApiGatewayService) {
        if (!this.currentUser && localStorage.getItem(this.localStorageUserKey)) {
            this.currentUser = this.getCurrentUserFromLocalStorage();
        }
    }

    public setCurrentUser(user: User) {
        this.currentUser = user;
        localStorage.setItem(this.localStorageUserKey, JSON.stringify(user));
    }

    public resetCurrentUser(): void {
        localStorage.removeItem(this.localStorageUserKey);
        this.currentUser = null;
    }

    public getCurrentUser(): User {
        return this.currentUser;
    }

    public getCurrentUserFromLocalStorage() : User {
        let userObject = JSON.parse(localStorage.getItem(this.localStorageUserKey));
        return this.createUserModel(userObject);
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

}
