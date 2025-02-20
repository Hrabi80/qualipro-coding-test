import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BandUploadComponent } from './band-upload.component';

describe('BandUploadComponent', () => {
  let component: BandUploadComponent;
  let fixture: ComponentFixture<BandUploadComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [BandUploadComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BandUploadComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
