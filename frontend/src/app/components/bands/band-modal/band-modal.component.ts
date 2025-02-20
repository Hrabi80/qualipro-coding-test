import { Component, EventEmitter, Input, Output, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { BandsService } from '../../../services/bands.service';
import { Band } from '../../../interfaces/band.interface';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-band-modal',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './band-modal.component.html',
  styleUrls: ['./band-modal.component.css'],
})
export class BandModalComponent implements OnInit {
  @Input() bandData: Band | null = null; 
  @Output() close = new EventEmitter<void>(); 
  @Output() bandSaved = new EventEmitter<void>();

  bandForm!: FormGroup;
  isEditMode = false;
  
  constructor(private fb: FormBuilder, private service: BandsService) {}

  ngOnInit() {
    this.isEditMode = !!this.bandData;
    console.log("bandData", this.bandData);
    this.bandForm = this.fb.group({
      name: [this.bandData?.name || '', Validators.required],
      origin: [this.bandData?.origin || '', Validators.required],
      city: [this.bandData?.city || '', Validators.required],
      founded_at: [this.bandData?.founded_at || '', Validators.required],
      separation_date: [this.bandData?.separation_date || ''],
      members: [this.bandData?.members || '', Validators.required],
      founders: [this.bandData?.founders || '', Validators.required],
      about: [this.bandData?.about || '', Validators.required],
    });
  }

  submitForm() {
    if (this.bandForm.invalid) {
      return;
    }

    if (this.isEditMode && this.bandData) {
      this.service.updateBand(this.bandData.id, this.bandForm.value).subscribe({
        next: () => {
          Swal.fire('Succès', 'Le groupe a été mis à jour !', 'success');
          this.bandSaved.emit();
          this.close.emit();
        },
        error: (err) => {
          Swal.fire('Erreur', 'Une erreur est survenue!', 'error');
          console.error(err);
        },
      });
    } else {
      this.service.createBand(this.bandForm.value).subscribe({
        next: () => {
          Swal.fire('Succès', 'Le groupe est ajouté correctement!', 'success');
          this.bandSaved.emit();
          this.close.emit();
        },
        error: (err) => {
          Swal.fire('Erreur', 'Une erreur est survenue!', 'error');
          console.error(err);
        },
      });
    }
  }
}
