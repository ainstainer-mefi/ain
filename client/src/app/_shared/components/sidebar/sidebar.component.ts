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

  routes: Object[] = [{
    icon: 'home',
    route: '/page/home',
    title: 'Home',
  }, {
    icon: 'description',
    route: '/page/docs',
    title: 'Documentation',
  }, {
    icon: 'perm_contact_calendar',
    route: '/page/calendar',
    title: 'Calendar',
  },{
    icon: 'supervisor_account',
    route: '/page/members',
    title: 'Members',
  }
  ];

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
