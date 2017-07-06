import {Injectable} from '@angular/core';
import {ApiGatewayService} from '../api-gateway.service';

@Injectable()
export class JiraService {

    private urlBind = '/api/bind-jira-account';
    private urlUnnind = '/api/unbind-jira-account';

    constructor(private apiGatewayService: ApiGatewayService) {

    }

    bindJiraAccount(params) {
        return this.apiGatewayService.post(this.urlBind, false, params)
            .map((response: any) => {
                return response;
            });
    }

    unbindJiraAccount(params) {
        return this.apiGatewayService.delete(this.urlUnnind, false, params)
            .map((response: any) => {
                return response;
            });
    }
}
