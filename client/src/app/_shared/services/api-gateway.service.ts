import {Injectable} from '@angular/core';
import {Http, Response, RequestOptions, RequestMethod, URLSearchParams, Headers} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {Subject} from 'rxjs/Subject';
import { SnackbarService} from './snackbar.service';

export class ApiGatewayOptions {
  method: RequestMethod;
  url: string;
  headers = {};
  params = {};
  data = {};
}

@Injectable()
export class ApiGatewayService {

  // Define the internal Subject we'll use to push errors
  private errorsSubject = new Subject<any>();

  // Provide the *public* Observable that clients can subscribe to
  public errors: Observable<any>;

  constructor(private http: Http, private alert: SnackbarService) {
    // Create our observables from the subjects
    this.errors = this.errorsSubject.asObservable();
  }

  // I perform a GET request to the API, appending the given params
  // as URL search parameters. Returns a stream.
  get(url: string, params: any, sendAuthToken: boolean = true): Observable<Response> {
    const options = new ApiGatewayOptions();
    options.method = RequestMethod.Get;
    options.url = url;
    options.params = params;

    return this.request(options, sendAuthToken);
  }


  // I perform a POST request to the API. If both the params and data
  // are present, the params will be appended as URL search parameters
  // and the data will be serialized as a JSON payload. If only the
  // data is present, it will be serialized as a JSON payload. Returns
  // a stream.
  post(url: string, params: any, data: any, sendAuthToken: boolean = true): Observable<Response> {
    if (!data) {
      data = params;
      params = {};
    }
    const options = new ApiGatewayOptions();
    options.method = RequestMethod.Post;
    options.url = url;
    options.params = params;
    options.data = data;

    return this.request(options, sendAuthToken);
  }


  private request(options: ApiGatewayOptions, sendAuthToken: boolean): Observable<any> {

    options.method = (options.method || RequestMethod.Get);
    options.url = (options.url || '');
    options.headers = (options.headers || {});
    options.params = (options.params || []);
    options.data = (options.data || {});

    if (sendAuthToken) {
      this.addAuthToken(options);
    }

    this.addContentType(options);

    const requestOptions = new RequestOptions();
    requestOptions.method = options.method;
    requestOptions.url = options.url;
    requestOptions.headers = new Headers(options.headers);
    requestOptions.params = this.buildUrlSearchParams(options.params);
    requestOptions.body = JSON.stringify(options.data);


    const stream = this.http.request(options.url, requestOptions)
      .catch((error: any) => {
        //console.log(error.status);
        //console.log(error);
        this.errorsSubject.next(error);
        return Observable.throw(error);
      })
      .map(this.unwrapHttpValue)
      .catch((error: any) => {
        return Observable.throw(this.unwrapHttpError(error));
      });

    return stream;
  }


  private addContentType(options: ApiGatewayOptions): ApiGatewayOptions {
    if (options.method !== RequestMethod.Get) {
      options.headers['Content-Type'] = 'application/json; charset=UTF-8';
    }
    return options;
  }

  private extractValue(collection: any, key: string): any {
    const value = collection[key];
    delete (collection[key]);
    return value;
  }

  private addAuthToken(options: ApiGatewayOptions): ApiGatewayOptions {
    options.headers['Authorization'] = 'Bearer ' + localStorage.getItem('apiToken');
    return options;
  }

  private buildUrlSearchParams(params: any): URLSearchParams {
    const searchParams = new URLSearchParams();
    for (const key in params) {
      if (params.hasOwnProperty(key)) {
        searchParams.append(key, params[key]);
      }
    }
    return searchParams;
  }

  private unwrapHttpError(error: any): any {
    try {
      const er = error.json();
      this.alert.show(er.error.code +'#'+er.error.message);
      return er;
    } catch (jsonError) {
      return ({
        code: -1,
        message: 'An unexpected error occurred.'
      });
    }
  }

  private unwrapHttpValue(value: Response): any {
    return (value.json());
  }

}
