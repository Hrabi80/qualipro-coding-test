import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BandModalComponent } from './band-modal.component';

describe('BandModalComponent', () => {
  let component: BandModalComponent;
  let fixture: ComponentFixture<BandModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BandModalComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BandModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
