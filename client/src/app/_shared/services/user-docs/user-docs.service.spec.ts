import { TestBed, inject } from '@angular/core/testing';

import { UserDocsService } from './user-docs.service';

describe('UserDocsService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [UserDocsService]
    });
  });

  it('should ...', inject([UserDocsService], (service: UserDocsService) => {
    expect(service).toBeTruthy();
  }));
});
