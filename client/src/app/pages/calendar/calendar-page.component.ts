import {Component, OnInit, OnDestroy} from '@angular/core';
import {Subject} from 'rxjs/Subject';
import {MdDialog} from '@angular/material';
import {NgForm} from '@angular/forms';
import 'rxjs/add/operator/takeUntil';
import * as $ from 'jquery';

//import * as moment from 'moment';
import {Options} from "fullcalendar";
import {CalendarService, PreloaderService} from '../../_shared/services/index';
import  {CalendarEvent} from '../../_shared/models/calendar.event.model';
import {ExampleDialog} from "../../_shared/components/dialogs/example-dialog";


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


    constructor(private _calendarService: CalendarService,
                private _preloaderService: PreloaderService,
                public dialog: MdDialog) {

    }

    /*openDialog() {
     this.dialog.open(ExampleDialog);
     }*/

    ngOnInit() {
        this.calendarOptions = this._calendarService.getCalendarOptions();
    }

    ngOnDestroy() {
        this._ngUnsubscribe.next();
        this._ngUnsubscribe.complete();
    }

    refreshEvents(): void {
        this.loadEvents('refreshEvents');
    }

    onCalendarReady(calendar): void {
        this._calendar = calendar;
        this.loadEvents('renderEvents');
    }

    onEventClick(eventClickData): void {
        this.selectedEvent = eventClickData.calEvent;
    }

    onSelect(selectedData): void {
        //this.openDialog();
        if (this._calendar != null) {
            this.eventData = {
                start: selectedData.start,
                end: selectedData.end,
                range: $.fullCalendar.formatRange(selectedData.start, selectedData.end, 'MMMM D YYYY')

            };
            console.log(this.eventData);
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

    submit(form: NgForm){
        console.log(form);
        console.log(form.value);
    }

    private loadEvents(type) {

        this._preloaderService.register();
        this._calendarService.getEvents()
            .takeUntil(this._ngUnsubscribe)
            .subscribe(
                (data: Array<CalendarEvent>) => {
                    //console.log(data);
                    this.items = data;
                    if (type == 'refreshEvents') {
                        $(this._calendar).fullCalendar('removeEvents');
                    }
                    $(this._calendar).fullCalendar('renderEvents', this.items, true);
                    this._preloaderService.resolve();

                },
                (error: any) => {
                    this._preloaderService.resolve();
                });
    }


}

