import { Injectable } from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';

@Injectable()
export class PreloaderService {

    private subject = new BehaviorSubject<boolean>(false);

    constructor() {}

    public register() {
        this.subject.next(true);
    }

    public resolve() {
        this.subject.next(false);
    }

    public getSubject(): BehaviorSubject<boolean> {
        return this.subject;
    }

}