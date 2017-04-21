import {Component, ViewChild, Input, Output, AfterViewInit, ElementRef, EventEmitter} from '@angular/core';
import * as $ from 'jquery';
import 'fullcalendar';
import {Options, ViewObject} from "fullcalendar";

@Component({
    templateUrl: './calendar.component.html',
    styleUrls: ['./calendar.component.scss'],
    selector: 'app-fullcalendar'
})
export class CalendarComponent{

    @Input() options: Options;
    @Input() calendarClass:string;

    @Output() onCalendarReady = new EventEmitter<any>();

    @ViewChild('appFullCalendar') public _selector:ElementRef;

    constructor() {
    }


    ngAfterViewInit(){
        setTimeout(()=>{
            //console.log("100ms after ngAfterViewInit ");
            //$('app-fullcalendar').fullCalendar(this.options);
            let calendar = $(this._selector.nativeElement).fullCalendar(this.options);
            this.onCalendarReady.emit(calendar);
        }, 100);

    }

    updateEvent(event) {
        return $(this._selector.nativeElement).fullCalendar('updateEvent', event);
    }

    clientEvents(idOrFilter) {
        return $(this._selector.nativeElement).fullCalendar('clientEvents', idOrFilter);
    }

    navigate(value) {
        $(this._selector.nativeElement).fullCalendar(value);
    }

    view(value) {
        $(this._selector.nativeElement).fullCalendar('changeView',value);
    }
}
