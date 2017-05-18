import { Component } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';
import { MdIconRegistry } from '@angular/material';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})

export class AppComponent {

  constructor(
      private _iconRegistry: MdIconRegistry,
      private _domSanitizer: DomSanitizer) {
     this._iconRegistry.addSvgIconInNamespace('assets', 'jira',
         this._domSanitizer.bypassSecurityTrustResourceUrl('assets/icons/jira3.svg'));


  }

}
