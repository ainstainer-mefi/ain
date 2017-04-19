import {Injectable} from '@angular/core';

import {Observable} from 'rxjs/Observable';
import {BehaviorSubject} from 'rxjs/BehaviorSubject';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/catch';

import {ApiGatewayService} from '../api-gateway.service';
import {ConfigService} from '../config.service';


@Injectable()
export class UserDocsService {

    private url = '/api/user-files';

    constructor(private apiGatewayService: ApiGatewayService, private configService: ConfigService) {
    }

    getDocs() {
        return this.apiGatewayService.get(this.url, {})
            .map((response: any) => {
                return response;
            });
    }
}
