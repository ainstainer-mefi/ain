import { Component,  Input, OnInit } from '@angular/core';
import {PreloaderService} from '../../services/index';

@Component({
  selector: 'app-progress-bar',
  templateUrl: './progress-bar.component.html',
  styleUrls: ['./progress-bar.component.scss']
})
export class ProgressBarComponent implements OnInit {

  show = false;
  color = 'primary'; // warn, accent, primary
  mode = 'indeterminate';

  private loaderSubject;

  constructor(private _preloaderService: PreloaderService) {
    this.loaderSubject = this._preloaderService.getSubject();
  }
  ngOnInit() {
    this.loaderSubject.subscribe(
        (show) => (this.show = show)
    );
  }
  //
  // @Input()
  // public set isRunning(value: boolean) {
  //
  //   if (!value) {
  //     this.show = false;
  //   } else {
  //     this.show = true;
  //   }
  //
  // }



}
