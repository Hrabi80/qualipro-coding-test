import { Component, EventEmitter, Input, Output } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { PartyHall } from '../../../interfaces/Party-hall.interface';
import { HallsService } from '../../../services/halls.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-hall-modal',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './hall-modal.component.html',
  styleUrl: './hall-modal.component.css'
})
export class HallModalComponent {
    @Input() hallData: PartyHall | null = null;
    @Output() close = new EventEmitter<void>(); 
    @Output() bandSaved = new EventEmitter<void>(); 
  
    hallForm!: FormGroup;
    isEditMode = false;
    
    constructor(private fb: FormBuilder, private service: HallsService) {}

    ngOnInit() {
        this.isEditMode = !!this.hallData;
        this.hallForm = this.fb.group({
          name: [this.hallData?.name || '', Validators.required],
          address: [this.hallData?.address || '', Validators.required],
          city: [this.hallData?.city || '', Validators.required],
        });
      }
    
      submitForm() {
        if (this.hallForm.invalid) {
          return;
        }
    
        if (this.isEditMode && this.hallData) {
          this.service.updateHall(this.hallData.id, this.hallForm.value).subscribe({
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
          // Create new band
          this.service.createHall(this.hallForm.value).subscribe({
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
