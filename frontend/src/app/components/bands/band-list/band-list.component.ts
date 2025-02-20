import { Component } from '@angular/core';
import { Band } from '../../../interfaces/band.interface';
import { BandsService } from '../../../services/bands.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-band-list',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './band-list.component.html',
  styleUrl: './band-list.component.css'
})
export class BandListComponent {
  bands: Band[]=[];
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
}
