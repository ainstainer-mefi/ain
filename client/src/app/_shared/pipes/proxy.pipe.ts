import { Pipe, PipeTransform } from '@angular/core';
import {ConfigService} from '../../_shared/services/index';

@Pipe({
  name: 'proxy'
})
export class ProxyPipe implements PipeTransform {

  constructor( private config: ConfigService) {
  }

  transform(value: any, args?: any): any {
    return value;
    //return this.config.getConfig('apiUrl') + '/proxy?url='+ value;
  }

}
