import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subject } from 'rxjs/Subject';
import 'rxjs/add/operator/takeUntil';
import * as $ from 'jquery';
//import * as moment from 'moment';
import { Options } from "fullcalendar";
import { CalendarService, PreloaderService } from '../../_shared/services/index';
import {CalendarEvent} from '../../_shared/models/calendar.event.model';


@Component({
  selector: 'app-calendar',
  templateUrl: './calendar-page.component.html',
  styleUrls: ['./calendar-page.component.scss'],
  providers: [CalendarService]
})
export class CalendarPageComponent implements OnInit, OnDestroy {

  private _ngUnsubscribe: Subject<void> = new Subject<void>();
  private _calendar: Object;
  public eventData: any = false;
  public selectedEvent: any = false;
  public items: Array<CalendarEvent> = [];
  public calendarOptions: Options;


  constructor(
      private _calendarService: CalendarService,
      private _preloaderService: PreloaderService
  ) {

  }


  ngOnInit(){
    this.calendarOptions = this._calendarService.getCalendarOptions();
    this.calendarOptions.select = (start, end) => this._onSelect(start, end);
    this.calendarOptions.eventClick = (calEvent, jsEvent, view) => this._eventClick(calEvent, jsEvent, view);
  }

  ngOnDestroy() {
    this._ngUnsubscribe.next();
    this._ngUnsubscribe.complete();
  }

  private loadEvents() {

    this._preloaderService.register();
    this._calendarService.getEvents()
        .takeUntil(this._ngUnsubscribe)
        .subscribe(
            (data:Array<CalendarEvent>) => {
              //console.log(data);
              this.items = data;
              $(this._calendar).fullCalendar('renderEvents', this.items, true);
              this._preloaderService.resolve();

            },
            (error: any) => {
              this._preloaderService.resolve();
            });
  }

  public onCalendarReady(calendar):void {
    this._calendar = calendar;
    this.loadEvents();
  }

  private _eventClick(calEvent, jsEvent, view):void {
    console.log(calEvent);
    this.selectedEvent = calEvent;
  }

  private _onSelect(start, end):void {

    if (this._calendar != null) {
      //eventData.end.subtract(1, 'day').format('DD.MM.YYYY')
      this.eventData = {
        start: start,
        end: end,
        displayStart: start.format('DD.MM.YYYY'),
        displayEnd: end.subtract(1, 'day').format('DD.MM.YYYY')

      };
      //console.log(this.eventData);
      /*let title = prompt('Event Title:');
      let eventData;
      if (title) {
        eventData = {
          title: title,
          start: start,
          end: end
        };
        console.log(eventData);
        $(this._calendar).fullCalendar('renderEvent', eventData, true);
      }
      $(this._calendar).fullCalendar('unselect');*/
    }
  }


}
