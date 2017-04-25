import { Component, Input } from '@angular/core';

@Component({
    templateUrl: './avatar.component.html',
    styleUrls: ['./avatar.component.scss'],
    selector: 'app-avatar'
})
export class AvatarComponent{

    @Input() imageUrl: string;
    @Input() avatarClass: string = '';
    @Input() useRound: boolean = true;
    @Input() size: string = '55px';

    constructor() {

    }

    ngAfterViewInit(){

    }

}
