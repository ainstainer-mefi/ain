import {Component} from '@angular/core';
import {ConfigService} from './_shared/services/index';
import { DomSanitizer } from '@angular/platform-browser';
import { MdIconRegistry } from '@angular/material';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})

export class AppComponent {

  constructor(private config: ConfigService,private _iconRegistry: MdIconRegistry,
              private _domSanitizer: DomSanitizer) {
    console.log('AppComponent');
    //console.log(config.getConfig('apiUrl'));
    this._iconRegistry.addSvgIconInNamespace('assets', 'covalent',
        this._domSanitizer.bypassSecurityTrustResourceUrl('assets/icons/covalent.svg'));
    this._iconRegistry.addSvgIconInNamespace('assets', 'ain',
        this._domSanitizer.bypassSecurityTrustResourceUrl('assets/icons/ain.svg'));


  }


}
