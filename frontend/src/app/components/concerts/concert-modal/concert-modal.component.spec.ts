import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ConcertModalComponent } from './concert-modal.component';

describe('ConcertModalComponent', () => {
  let component: ConcertModalComponent;
  let fixture: ComponentFixture<ConcertModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ConcertModalComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ConcertModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
