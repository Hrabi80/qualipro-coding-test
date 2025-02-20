import { Component } from '@angular/core';
import { BandsService } from '../../../services/bands.service';
import Swal from 'sweetalert2';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-band-upload',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './band-upload.component.html',
  styleUrls: ['./band-upload.component.css'],
})
export class BandUploadComponent {
  selectedFile: File | null = null;
  isUploading = false;

  constructor(private service: BandsService) {}

  /**
   * Handles file selection.
   */
  onFileSelected(event: Event) {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
      this.selectedFile = target.files[0];
    }
  }

  /**
   * Uploads the selected file to the backend.
   */
  uploadFile() {
    if (!this.selectedFile) {
      Swal.fire('Erreur', 'Veuillez sélectionner un fichier Excel.', 'warning');
      return;
    }

    this.isUploading = true;
    this.service.importExcel(this.selectedFile).subscribe({
      next: (response) => {
        Swal.fire('Succès', response.message, 'success');
        this.selectedFile = null;
      },
      error: (error) => {
        Swal.fire('Erreur', 'Échec de l’importation du fichier.', 'error');
      },
      complete: () => {
        this.isUploading = false;
      },
    });
  }
}
