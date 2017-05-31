import {Component, ViewChild, Input, Output, AfterViewInit, OnInit, ElementRef, EventEmitter} from '@angular/core';
import * as $ from 'jquery';
import 'fullcalendar';
import {Options} from "fullcalendar";
import {TranslateService} from '@ngx-translate/core';

@Component({
    templateUrl: './calendar.component.html',
    styleUrls: ['./calendar.component.scss'],
    selector: 'app-fullcalendar'
})
export class CalendarComponent implements OnInit, AfterViewInit {

    listDayChecked: boolean = false;
    @Input() options: Options;
    @Input() calendarClass: string;
    @Output() onCalendarReady = new EventEmitter<any>();

    @ViewChild('appFullCalendar') public _selector: ElementRef;

    constructor(private _translateService: TranslateService) {

    }

    ngOnInit(){
        this.options.locale = this._translateService.currentLang;
        this.options.navLinkDayClick = (date, jsEvent) => this.linkDayClick(date, jsEvent);
        this._translateService.onLangChange.subscribe((params) => {
            $(this._selector.nativeElement).fullCalendar('option', 'locale', params.lang);
        });
    }

    ngAfterViewInit(){

        let calendar = $(this._selector.nativeElement).fullCalendar(this.options);
        this.onCalendarReady.emit(calendar);
        // setTimeout(()=>{
        //     //console.log("100ms after ngAfterViewInit ");
        //     //$('app-fullcalendar').fullCalendar(this.options);
        //
        // }, 100);

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

    changeView(value) {
        if(value !== 'listDay'){
            this.listDayChecked = false;
        }
        $(this._selector.nativeElement).fullCalendar('changeView', value);
    }

    linkDayClick(date, jsEvent){
        this.listDayChecked = true;
        $(this._selector.nativeElement).fullCalendar('changeView','listDay', date.format());
    }
}
