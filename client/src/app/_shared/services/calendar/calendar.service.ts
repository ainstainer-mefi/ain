import {Injectable} from '@angular/core';

import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/catch';
import {ApiGatewayService} from '../api-gateway.service';
import {CalendarEvent} from '../../models/calendar.event.model';
import { Options } from "fullcalendar";


@Injectable()
export class CalendarService {

    private url = '/api/calendar-event-list';

    private  calendarOptions:Options = {
        header: {
            left: false,
            center: 'title',
            right: false
        },

        navLinks: true,
        //titleFormat: 'MMMM D YYYY',
        nowIndicator: true,
        fixedWeekCount: false,
        firstDay: 1,
        selectable: true,
        selectHelper: true,
        businessHours: true, // display business hours
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events:[],
        aspectRatio: 2,
        timeFormat: 'H:mm', // uppercase H for 24-hour clock

    };

    constructor(private apiGatewayService: ApiGatewayService) {}

    getEvents() {
        return this.apiGatewayService.get(this.url, {})
            .map((response: any) => {
                return response.map( (event: any) => {
                    return new CalendarEvent(event);
                });
            });
    }

    getCalendarOptions(): Options {
        return this.calendarOptions;
    }
}
