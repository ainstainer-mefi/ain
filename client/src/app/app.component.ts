import {Component} from '@angular/core';
import {ConfigService} from './_shared/services/index';



@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})

export class AppComponent {

  constructor(private config: ConfigService) {
    console.log('AppComponent');
    //console.log(config.getConfig('apiUrl'));
  }

}
