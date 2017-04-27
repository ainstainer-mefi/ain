import { Component, OnInit } from '@angular/core';
import { StepState } from '@covalent/core';

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


    activeDeactiveStep1Msg: string = 'No select/deselect detected yet';
    stateStep2: StepState = StepState.Required;
    stateStep3: StepState = StepState.Complete;
    disabled: boolean = false;

    toggleRequiredStep2(): void {
        this.stateStep2 = (this.stateStep2 === StepState.Required ? StepState.None : StepState.Required);
    }

    toggleCompleteStep3(): void {
        this.stateStep3 = (this.stateStep3 === StepState.Complete ? StepState.None : StepState.Complete);
    }

    activeStep1Event(): void {
        this.activeDeactiveStep1Msg = 'Active event emitted.';
    }

    deactiveStep1Event(): void {
        this.activeDeactiveStep1Msg = 'Deactive event emitted.';
    }
}
