import { Input, Component,  AfterViewInit, ViewEncapsulation, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { MdMenuTrigger } from '@angular/material';

import {AuthenticationService, ConfigService} from '../../services/index';
import {
	UserService
} from '../../services/index';
import {  trigger,
	state,
	style,
	transition,
	animate,
	keyframes} from '@angular/animations';

@Component({
	selector: 'app-user-menu',
	templateUrl: './user-menu.component.html',
	styleUrls: ['./user-menu.component.scss'],
	//encapsulation: ViewEncapsulation.None
	/*animations: [
		trigger('toggleState', [
			state('true' , style({  })),
			state('false', style({ maxHeight: 0, padding: 0, display: 'none' })),
			// transition
			transition('* => *', animate('300ms')),
		])
	]*/
})
export class UserMenuComponent implements AfterViewInit {

	currentUser;
	@ViewChild(MdMenuTrigger) trigger: MdMenuTrigger;
	constructor(private router: Router,
	            private auth: AuthenticationService,
	            private config: ConfigService,
				private user: UserService) {
		this.currentUser = user.getCurrentUser();
		console.log(this.currentUser)
	}

	openMenu() {
		this.trigger.openMenu();
	}

	ngAfterViewInit() {
		gapi.load('auth2', () => {
			gapi.auth2.init({client_id: this.config.getGoogleClientId(), fetch_basic_profile: true});
		});
	}

	logout() {
		const auth2 = gapi.auth2.getAuthInstance();
		auth2.signOut().then(() => {
			this.auth.logout();
			this.router.navigate(['/login']);
		});
	}

	singOut() {
		const auth2 = gapi.auth2.getAuthInstance();
		auth2.disconnect().then(() => {
			this.router.navigate(['/login'])
		});
	}

}

