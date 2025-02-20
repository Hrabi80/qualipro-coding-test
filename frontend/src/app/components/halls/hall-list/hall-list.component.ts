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
}
