import {Input, Component,  AfterViewInit} from '@angular/core';
import {Router} from '@angular/router';
import {AuthenticationService, ConfigService} from '../../services/index';


@Component({
	selector: 'app-user-menu',
	templateUrl: './user-menu.component.html',
	styleUrls: ['./user-menu.component.scss']
})
export class UserMenuComponent implements AfterViewInit {

	@Input() userPicture: string;

	constructor(private router: Router,
	            private auth: AuthenticationService,
	            private config: ConfigService,) {
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

