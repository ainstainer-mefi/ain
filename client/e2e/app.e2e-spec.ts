import { Ain4Page } from './app.po';

describe('ain4 App', () => {
  let page: Ain4Page;

  beforeEach(() => {
    page = new Ain4Page();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
