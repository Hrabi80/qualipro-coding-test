import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { ConcertModalComponent } from '../concert-modal/concert-modal.component';
import { Concert, ConcertResonse } from '../../../interfaces/concert.interface';
import { ConcertsService } from '../../../services/concerts.service';

@Component({
  selector: 'app-concert-list',
  standalone: true,
  imports: [CommonModule,ConcertModalComponent],
  templateUrl: './concert-list.component.html',
  styleUrl: './concert-list.component.css'
})
export class ConcertListComponent {
  concerts: ConcertResonse[]=[];
  showModal = false;
  selectedConsert: Concert | null = null;
  constructor(private service: ConcertsService) {}
  ngOnInit() {
        this.getHalls();
      }
    getHalls(){
      this.service.getConcerts().subscribe((concerts: ConcertResonse[]) => {
        console.log("concerts===>",concerts);
        this.concerts = concerts;
      });
    }
    openModal(hall: Concert | null = null) {
        this.selectedConsert = hall;
        this.showModal = true;
      }
    
      closeModal() {
        this.showModal = false;
        this.selectedConsert = null;
      }
    
      refreshList() {
        this.getHalls();
      }
}
