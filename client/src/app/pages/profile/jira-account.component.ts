import {Component, OnInit, Input} from '@angular/core';
import {JiraService, PreloaderService} from '../../_shared/services/index';
import {FormControl, FormGroup, Validators} from '@angular/forms';

@Component({
    selector: 'app-jira',
    templateUrl: './jira-account.component.html',
    styleUrls: ['./jira-account.component.scss'],
    providers: [JiraService]
})
////'^\s*[a-zA-Z0-9.-_]+@ainstainer.de'
export class JiraAccountComponent {

    private EMAIL_REGEXP = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;

    public countActiveAccount: number = 0;

    public _accounts: Array<any> = [];

    public expandPanel = false;


    constructor(private _jiraService: JiraService, private _preloaderService: PreloaderService) {

        this.expandPanel = localStorage.getItem('jira-account.component.expand') ? true : false;
    }


    @Input()
    set accounts(accounts: Array<any>) {
        let emailValidators = [Validators.required, Validators.pattern(this.EMAIL_REGEXP)];
        let passwordValidators = [Validators.required, Validators.minLength(6)];
        accounts.map((account: any) => {
            account.form = new FormGroup({
                'email': new FormControl('', emailValidators),
                'password': new FormControl('', passwordValidators),
            });
            if(account.active){
                this.countActiveAccount++;
            }
            this._accounts.push(account);
        });

    }

    get accounts() {
        return this._accounts;
    }


    bindJira(account): void {
        let params = account.form.value;
        params.id = account.id;
        this._preloaderService.register();
        this._jiraService.bindJiraAccount(params).subscribe(
            (data) => {
                this.countActiveAccount++;
                this._preloaderService.resolve();
                account.active = 1;
                //console.log(account);
            },
            (error: any) => {
                this._preloaderService.resolve();
                console.warn('Server connection problem');
                console.dir(error);
            });
    }

    unbind(account): void {

        this._preloaderService.register();
        this._jiraService.unbindJiraAccount({id: account.id}).subscribe(
            (data) => {
                this.countActiveAccount--;
                this._preloaderService.resolve();
                account.active = 0;
                account.form.reset();
            },
            (error: any) => {
                this._preloaderService.resolve();
                console.warn('Server connection problem');
                console.dir(error);
            });
    }

    expandedEvent(): void {

        localStorage.setItem('jira-account.component.expand', 'true');
        //localStorage.removeItem('apiToken');
        console.log('expandedEvent');
    }

    collapsedEvent(): void {
        console.log('collapsedEvent');
        localStorage.removeItem('jira-account.component.expand');
    }

}
