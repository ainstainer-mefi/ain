import { Component,  Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-progress-bar',
  templateUrl: './progress-bar.component.html',
  styleUrls: ['./progress-bar.component.scss']
})
export class ProgressBarComponent implements OnInit {

  show = false;
  color = 'primary'; // warn, accent, primary
  mode = 'indeterminate';

  @Input()
  public set isRunning(value: boolean) {

    if (!value) {
      this.show = false;
    } else {
      this.show = true;
    }

  }

  ngOnInit() {}

}
