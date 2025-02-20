import { Routes } from '@angular/router';


export const routes: Routes = [
  {path: 'bands', loadComponent: () => import('./components/bands/band-list/band-list.component').then(mod => mod.BandListComponent)},
  {path: 'upload', loadComponent: () => import('./components/bands/band-upload/band-upload.component').then(mod => mod.BandUploadComponent)},
  {path: 'halls', loadComponent: () => import('./components/halls/hall-list/hall-list.component').then(mod => mod.HallListComponent)},
  {path: 'concerts', loadComponent: () => import('./components/concerts/concert-list/concert-list.component').then(mod => mod.ConcertListComponent)},

  { path: '', redirectTo: 'bands', pathMatch: 'full' }, // Default Route
  { path: '**', redirectTo: 'bands' } // Wildcard (404) Route
];