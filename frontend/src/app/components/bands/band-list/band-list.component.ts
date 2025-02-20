import { Component } from '@angular/core';
import { Band } from '../../../interfaces/band.interface';
import { BandsService } from '../../../services/bands.service';
import { CommonModule } from '@angular/common';
import { BandModalComponent } from '../band-modal/band-modal.component';

@Component({
  selector: 'app-band-list',
  standalone: true,
  imports: [CommonModule,BandModalComponent],
  templateUrl: './band-list.component.html',
  styleUrl: './band-list.component.css'
})
export class BandListComponent {
  bands: Band[]=[];
  showModal = false;
  selectedBand: Band | null = null;
  constructor(private service: BandsService) {
  }
  ngOnInit() {
    this.getBands();
  }
  getBands(){
    this.service.getBands().subscribe((bands: Band[]) => {
      console.log("bands", bands);
      this.bands = bands;
    });
  }
  openModal(band: Band | null = null) {
    this.selectedBand = band;
    console.log("selectedBand", this.selectedBand);
    this.showModal = true;
  }

  closeModal() {
    this.showModal = false;
    this.selectedBand = null;
  }

  refreshList() {
    this.getBands();
  }
}
