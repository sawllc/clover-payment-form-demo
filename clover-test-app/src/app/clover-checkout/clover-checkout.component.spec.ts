import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CloverCheckoutComponent } from './clover-checkout.component';

describe('CloverCheckoutComponent', () => {
  let component: CloverCheckoutComponent;
  let fixture: ComponentFixture<CloverCheckoutComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CloverCheckoutComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CloverCheckoutComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
