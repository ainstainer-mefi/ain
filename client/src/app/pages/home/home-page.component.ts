import { Component, OnInit } from '@angular/core';

@Component({
    templateUrl: './home-page.component.html',
    styleUrls: ['./home-page.component.scss']
})

export class HomePageComponent implements OnInit {

    /*config: Object = {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        spaceBetween: 10,
    };*/

    constructor() {
        console.log('HomeComponent');
    }

    ngOnInit() {

    }
}
