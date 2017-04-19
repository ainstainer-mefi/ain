import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';

// localStorage.setItem('apiUrl','http://localhost:2000')

@Injectable()
export class ConfigService {

  private config: any = null;
  private isProduction: boolean = null;

  constructor() {
    this.isProduction = environment.production;
    this.config = environment;
  }

  /**
   * Use to get the data found in the second file (config file)
   */
  public getConfig(key: any) {
    if (key === 'apiUrl' && localStorage.getItem('apiUrl')){
      return localStorage.getItem('apiUrl');
    }
    return this.config[key];
  }

   /**
   * Return all config object
   *  @returns {Object}
   */
  public getAll() {
      return this.config;
  }

  /**
   *  Get name environment
   */
  public getEnv(): string {
    return this.isProduction ? 'prod' : 'dev';
  }

  /**
   *
   * @returns {string}
   */
  public getGoogleScope(): string {
    return this.getConfig('google').scope.join(' ');
  }

  /**
   *
   * @returns {string}
   */
  public getGoogleClientId(): string {
    return this.getConfig('google').clientId;
  }
}
