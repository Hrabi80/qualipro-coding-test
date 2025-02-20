import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { HallModalComponent } from '../hall-modal/hall-modal.component';
import { PartyHall } from '../../../interfaces/Party-hall.interface';
import { HallsService } from '../../../services/halls.service';

@Component({
  selector: 'app-hall-list',
  standalone: true,
  imports: [CommonModule,HallModalComponent],
  templateUrl: './hall-list.component.html',
  styleUrl: './hall-list.component.css'
})
export class HallListComponent {
  halls: PartyHall[]=[];
  showModal = false;
  selectedHall: PartyHall | null = null;
  constructor(private service: HallsService) {}

  ngOnInit() {
      this.getHalls();
    }
  getHalls(){
    this.service.getHalls().subscribe((halls: PartyHall[]) => {
      this.halls = halls;
    });
  }
  openModal(hall: PartyHall | null = null) {
      this.selectedHall = hall;
      this.showModal = true;
    }
  
    closeModal() {
      this.showModal = false;
      this.selectedHall = null;
    }
  
    refreshList() {
      this.getHalls();
    }
}
