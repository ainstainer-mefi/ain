import { Injectable } from '@angular/core';
import {  MdSnackBar } from '@angular/material';

@Injectable()
export class SnackbarService {

  constructor(private snackbarService: MdSnackBar) {

  }

  public show(message: string = 'The Message') {
    const params = {
      message: message,
      action: {
        handler: () => {},
        text: 'OK'
      }
    };
    this.snackbarService.open(message, 'Ok', {
      duration: 3000
    });
  }

  /*public showWithAction(message: string = 'The Message') {
    const params = {
      message: message,
      action: {
        handler: () => {
          this.mdlSnackbarService.showToast('You hit the ok Button');
        },
        text: 'OK'
      }
    };

    this.mdlSnackbarService.showSnackbar(params);

  }*/

}