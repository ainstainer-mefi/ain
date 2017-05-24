import { Component , OnInit,  AfterViewInit } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';
import { MdIconRegistry } from '@angular/material';
import { ConfigService } from './_shared/services/index';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})

export class AppComponent  implements OnInit, AfterViewInit  {

  constructor(
      private _iconRegistry: MdIconRegistry,
      private _domSanitizer: DomSanitizer,
      private config: ConfigService) {
     this._iconRegistry.addSvgIconInNamespace('assets', 'jira',
         this._domSanitizer.bypassSecurityTrustResourceUrl('assets/icons/jira3.svg'));


  }

  ngOnInit() {

  }

  ngAfterViewInit() {

    /*gapi.load('auth2', () => {
      gapi.auth2.init({
        client_id: this.config.getGoogleClientId(),
        scope: this.config.getGoogleScope(),
        fetch_basic_profile: true,
      });
    });*/

  }

}
