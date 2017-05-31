export class CalendarEvent {
    id: string;
    end: string;
    start: string;
    backgroundColor: string;
    textColor: string;
    title: string;
    editable:boolean = true;

    constructor(obj?: any) {
        this.id  = obj && obj.id || null;
        this.backgroundColor = obj && obj.backgroundColor || null;
        this.textColor = obj && obj.foregroundColor || null;
        this.title = obj && obj.summary || 'No title';
        this.start = obj && obj.startDate || null;
        this.end = obj && obj.endDate || null;
    }
}