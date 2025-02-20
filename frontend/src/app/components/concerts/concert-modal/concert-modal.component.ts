import { Component, EventEmitter, Input, Output } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import Swal from 'sweetalert2';
import { Concert } from '../../../interfaces/concert.interface';
import { ConcertsService } from '../../../services/concerts.service';
import { BandsService } from '../../../services/bands.service';
import { HallsService } from '../../../services/halls.service';
import { PartyHall } from '../../../interfaces/Party-hall.interface';
import { Band } from '../../../interfaces/band.interface';
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
  concertForm!: FormGroup;
  isEditMode = false;
  halls: PartyHall[] = [];
  bands: Band[] = [];
    constructor(private fb: FormBuilder, 
              private service: ConcertsService,
              private hallService: HallsService,
              private bandService: BandsService
    ) {}

  ngOnInit() {
      this.isEditMode = !!this.consertData;
      this.concertForm = this.fb.group({
        date: [this.consertData?.date || '', Validators.required],
        party_hall_id: [this.consertData?.party_hall_id|| '', Validators.required],
        band_ids: [this.consertData?.band_ids || '', Validators.required],
      });

      this.fetchHalls();
      this.fetchBands();
    }
  
  submitForm() {
    if (this.concertForm.invalid) {
      return;
    }
      
    if (this.isEditMode && this.consertData) {
      this.service.updateConcert(this.consertData.id, this.concertForm.value).subscribe({
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
      this.service.createConcert(this.concertForm.value).subscribe({
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

  fetchHalls() {
    this.hallService.getHalls().subscribe({
      next: (halls: PartyHall[]) => {
        this.halls = halls;
      },
      error: (err) => console.error('Error fetching halls:', err)
    });
  }

  fetchBands() {
    this.bandService.getBands().subscribe({
      next: (bands: Band[]) => {
        this.bands = bands;
      },
      error: (err) => console.error('Error fetching bands:', err)
    });
  }
}
