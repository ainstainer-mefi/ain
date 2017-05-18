import {Directive, HostListener, Input, HostBinding, OnInit} from '@angular/core';

@Directive({
    selector: '[bgcolor]'
})
export class BgColorDirective implements OnInit{

    @Input("bgcolor") color: string  = "#6b9311";

    ngOnInit(){
        this.color = '--theme-' + this.color;
    }

    constructor(){}

    @HostBinding("style.background-color") get getColor(){

        return window.getComputedStyle(document.body).getPropertyValue(this.color);
    }




}