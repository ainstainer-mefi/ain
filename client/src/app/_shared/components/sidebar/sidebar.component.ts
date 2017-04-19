import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit {

  constructor() { }

  ngOnInit() {
  }

  public isCollapsed: boolean = true;

  public collapsed(event:any):void {
    //console.log(event);
  }

  public expanded(event:any):void {
    //console.log(event);
  }

  public navExpand(event:any):void {
    //console.log(event);
  }
}
