import {Component, OnInit} from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {UserService, PreloaderService} from '../../_shared/services/index';

@Component({
    selector: 'app-profile',
    templateUrl: './profile-page.component.html',
    styleUrls: ['./profile-page.component.scss']

})
export class ProfilePageComponent implements OnInit {

    public isRequesting: boolean = false;
    public jiraAccounts: Array<any> = [];
    private EMAIL_REGEXP = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;


    constructor(private _userService: UserService,
                private _preloaderService: PreloaderService) {
    }

    ngOnInit() {
        this.loadProfileData();
    }

    private loadProfileData() {

        this.isRequesting = true;
        this._preloaderService.register();

        this._userService.getProfile()
            .subscribe(
                (data) => {
                    this.parseProfileServerData(data);
                    this.isRequesting = false;
                    this._preloaderService.resolve();
                },
                (error: any) => {
                    this._preloaderService.resolve();
                    this.isRequesting = false;
                    console.warn('Server connection problem');
                    console.dir(error);
                });
    }

    private parseProfileServerData(data) {


        this.jiraAccounts = data.jira_accounts;

    }



}
