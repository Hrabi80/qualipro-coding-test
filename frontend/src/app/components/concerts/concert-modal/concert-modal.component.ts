import { Component, EventEmitter, Input, Output } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import Swal from 'sweetalert2';
import { Concert } from '../../../interfaces/concert.interface';
import { ConcertsService } from '../../../services/concerts.service';
@Component({
  selector: 'app-concert-modal',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './concert-modal.component.html',
  styleUrl: './concert-modal.component.css'
})
export class ConcertModalComponent {
      @Input() consertData: Concert | null = null;
      @Output() close = new EventEmitter<void>(); 
      @Output() bandSaved = new EventEmitter<void>(); 
      hallForm!: FormGroup;
       isEditMode = false;

       constructor(private fb: FormBuilder, private service: ConcertsService) {}

       ngOnInit() {
               this.isEditMode = !!this.consertData;
               this.hallForm = this.fb.group({
                 date: [this.consertData?.date || '', Validators.required],
                 party_hall_id: [this.consertData?.party_hall_id|| '', Validators.required],
                 band_ids: [this.consertData?.band_ids || '', Validators.required],
               });
             }
           
             submitForm() {
               if (this.hallForm.invalid) {
                 return;
               }
           
               if (this.isEditMode && this.consertData) {
                 this.service.updateConcert(this.consertData.id, this.hallForm.value).subscribe({
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
                 this.service.createConcert(this.hallForm.value).subscribe({
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
