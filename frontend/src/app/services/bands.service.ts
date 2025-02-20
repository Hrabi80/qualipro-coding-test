import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Band } from '../interfaces/band.interface';
import { environment } from '../../environments/environment';

@Injectable({
   providedIn: 'root'
})
export class BandsService {
  private readonly api = `${environment.api_url}/bands`;
  private readonly upload_api = `${environment.api_url}/import/bands`;
  constructor(private http: HttpClient) { }

  private headers = new HttpHeaders({
    'Content-Type': 'application/json',
  });
  private get httpOptions() {
    return { headers: this.headers };
  }
  getBands(): Observable<Band[]> {
    return this.http.get<Band[]>(this.api+"/", this.httpOptions);
  }

  getBand(id: string): Observable<Band> {
    return this.http.get<Band>(`${this.api}/${id}`);
  }

  createBand(band: Band): Observable<Band> {
    return this.http.post<Band>(this.api, band);
  }

  updateBand(id: number|undefined, band: Band): Observable<Band> {
    return this.http.put<Band>(`${this.api}/${id}`, band);
  }

  deleteBand(id: string): Observable<void> {
    return this.http.delete<void>(`${this.api}/${id}`);
  }

  importExcel(file: File): Observable<any> {
    const formData = new FormData();
    formData.append('file', file);
    return this.http.post(this.upload_api, formData);
  }
}
