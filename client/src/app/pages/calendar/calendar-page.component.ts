import {Component, OnInit, OnDestroy} from '@angular/core';
import {Subject} from 'rxjs/Subject';
import {NgForm} from '@angular/forms';
import 'rxjs/add/operator/takeUntil';
import * as $ from 'jquery';

import * as moment from 'moment';
import {Options} from "fullcalendar";
import {CalendarService, PreloaderService} from '../../_shared/services/index';
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


    constructor(private _calendarService: CalendarService,
                private _preloaderService: PreloaderService
    ) {

    }

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
        this.loadEvents();
    }

    onEventClick(eventClickData): void {
        this.eventData = false;
        this.selectedEvent = eventClickData.calEvent;
        console.log(eventClickData.calEvent);
    }

    onSelect(selectedData): void {

        if (this._calendar != null) {
            this.selectedEvent = false;
            this.eventData = {
                start: selectedData.start,
                end: selectedData.end,
                range: $.fullCalendar.formatRange(selectedData.start, selectedData.end, 'MMMM D YYYY')
            };
        }
    }

    submitDelete(form: NgForm){


        this._preloaderService.register();
        this._calendarService.delereEvent(form.value.id)
            .subscribe(
                (data: CalendarEvent) => {
                    this.items = this.items.filter((item: CalendarEvent, index) => {
                        return item.id != form.value.id;
                    });
                    $(this._calendar).fullCalendar('removeEvents', form.value.id);
                    this.selectedEvent = false;
                    this._preloaderService.resolve();
                },
                (error: any) => {
                    this._preloaderService.resolve();
                });
    }

    submitAdd(form: NgForm){

        let eventData = {
            title: form.value.name,
            start: this.eventData.start.format('YYYY-MM-DD'),
            end: this.eventData.end.format('YYYY-MM-DD')
        };

        this._preloaderService.register();
        this._calendarService.addEvent(eventData)
            .subscribe(
                (data: CalendarEvent) => {
                    this.eventData = false;
                    $(this._calendar).fullCalendar('renderEvent', data, true);
                    $(this._calendar).fullCalendar('unselect');
                    this._preloaderService.resolve();
                },
                (error: any) => {
                    this._preloaderService.resolve();
                });

    }



    private loadEvents(type: string = 'renderEvents') {

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
