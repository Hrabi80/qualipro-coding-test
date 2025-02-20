import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { Concert, ConcertResonse } from '../interfaces/concert.interface';
@Injectable({
  providedIn: 'root'
})
export class ConcertsService {
  private readonly api = `${environment.api_url}/concerts`;
  constructor(private http: HttpClient) { }
  private headers = new HttpHeaders({
    'Content-Type': 'application/json',
  });
  private get httpOptions() {
    return { headers: this.headers };
  }
  getConcerts(): Observable<ConcertResonse[]> {
      return this.http.get<ConcertResonse[]>(this.api+"/", this.httpOptions);
  }
  getConcert(id: string): Observable<Concert> {
    return this.http.get<Concert>(`${this.api}/${id}`, this.httpOptions);
  }

  createConcert(concert: Concert): Observable<Concert> {
    return this.http.post<Concert>(this.api, concert, this.httpOptions);
  }

  updateConcert(id: number | undefined, concert: Concert): Observable<Concert> {
    return this.http.put<Concert>(`${this.api}/${id}`, concert, this.httpOptions);
  }

  deleteConcert(id: number): Observable<void> {
    return this.http.delete<void>(`${this.api}/${id}`, this.httpOptions);
  }
}
