import { Component, OnInit } from '@angular/core';
import * as $ from 'jquery';
import { Options } from "fullcalendar";

@Component({
  selector: 'app-calendar',
  templateUrl: './calendar-page.component.html',
  styleUrls: ['./calendar-page.component.scss']
})
export class CalendarPageComponent implements OnInit {

  private _calendar:Object;

  constructor() {
    this.calendarOptions.select = (start, end) => this._onSelect(start, end);
  }


  ngOnInit() {

  }

  public onCalendarReady(calendar):void {
    this._calendar = calendar;
    console.log('calendarReady')
  }

  calendarOptions:Options = {

    header: {
      left: false,
      center: 'title',
      right: false
    },
    nowIndicator: true,
    fixedWeekCount: false,
    firstDay: 1,
    selectable: true,
    selectHelper: true,
    businessHours: true, // display business hours
    locale: 'en',
    editable: true,
    eventLimit: true, // allow "more" link when too many events
    events: [
      {
        title: 'Business Lunch',
        start: '2017-04-20T13:00:00',
        constraint: 'businessHours'

      },
      {
        title: 'Long Event',
        start: '2017-04-20',
        end: '2017-04-25'
      },
      {
        id: 999,
        title: 'Repeating Event',
        start: '2017-04-09T16:00:00'
      },
      {
        id: 999,
        title: 'Repeating Event',
        start: '2017-04-16T16:00:00',


      },
      {
        title: 'Click for Google',
        url: 'http://google.com/',
        start: '2017-04-28T11:00:00',
        constraint: 'availableForMeeting', // defined below
        color: '#257e4a'

      }
    ]
  };

  private _onSelect(start, end):void {

    if (this._calendar != null) {
      let title = prompt('Event Title:');
      let eventData;
      if (title) {
        eventData = {
          title: title,
          start: start,
          end: end
        };
        $(this._calendar).fullCalendar('renderEvent', eventData, true);
      }
      $(this._calendar).fullCalendar('unselect');
    }
  }
}
