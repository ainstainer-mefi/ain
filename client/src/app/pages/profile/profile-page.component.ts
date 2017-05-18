import { Component, OnInit, Inject } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { UserService, PreloaderService } from '../../_shared/services/index';

@Component({
  selector: 'app-profile',
  templateUrl: './profile-page.component.html',
  styleUrls: ['./profile-page.component.scss']
})
export class ProfilePageComponent implements OnInit {

  public isRequesting: boolean = false;
  public jiraAccounts: Array<any> = [];
  private EMAIL_REGEXP = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
  //
  //'^\s*[a-zA-Z0-9.-_]+@ainstainer.de'

  constructor(private _userService: UserService, private _preloaderService: PreloaderService) {
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

              data.jira_accounts.map((account: any) => {
                account.form = new FormGroup({
                  'email': new FormControl('', [Validators.required,Validators.pattern(this.EMAIL_REGEXP)]),
                  'password': new FormControl('', [ Validators.required, Validators.minLength(6)]),
                });
                this.jiraAccounts.push(account);
              });

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

  onSubmit(account): void {
    this._preloaderService.register();

    this._userService.bindJiraAccount(account).subscribe(
        (data) => {
          console.log(data);
          account.active = 1;
          this._preloaderService.resolve();
        });
  }

  unbind(account): void {
    account.active = 0;
    account.form.reset();
  }

  expandedEvent(): void {
    console.log('expandedEvent')
  }

  collapsedEvent(): void {
    console.log('collapsedEvent')
  }

}
