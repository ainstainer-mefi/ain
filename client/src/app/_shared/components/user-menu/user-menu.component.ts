import {Input, Component,  AfterViewInit, ViewEncapsulation} from '@angular/core';
import {Router} from '@angular/router';
import {AuthenticationService, ConfigService} from '../../services/index';
import {
	UserService
} from '../../services/index';
// import {  trigger,
// 	state,
// 	style,
// 	transition,
// 	animate,
// 	keyframes} from '@angular/animations';

@Component({
	selector: 'app-user-menu',
	templateUrl: './user-menu.component.html',
	styleUrls: ['./user-menu.component.scss'],
	//encapsulation: ViewEncapsulation.None
	// animations: [
	// 	trigger('transformMenu', [
	// 		state('showing', style({
	// 			opacity: 1,
	// 			transform: `scale(1)`
	// 		})),
	// 		transition('void => *', [
	// 			style({
	// 				opacity: 0,
	// 				transform: `scale(0)`
	// 			}),
	// 			animate(`200ms cubic-bezier(0.25, 0.8, 0.25, 1)`)
	// 		]),
	// 		transition('* => void', [
	// 			animate('50ms 100ms linear', style({opacity: 0}))
	// 		])
	// 	])
	// ]
})
export class UserMenuComponent implements AfterViewInit {

	currentUser;

	constructor(private router: Router,
	            private auth: AuthenticationService,
	            private config: ConfigService,
				private user: UserService) {
		this.currentUser = user.getCurrentUser();
		console.log(this.currentUser)
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

