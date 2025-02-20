import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HallModalComponent } from './hall-modal.component';

describe('HallModalComponent', () => {
  let component: HallModalComponent;
  let fixture: ComponentFixture<HallModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [HallModalComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(HallModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
