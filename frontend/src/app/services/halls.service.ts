import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { PartyHall } from '../interfaces/Party-hall.interface';


@Injectable({
  providedIn: 'root'
})
export class HallsService {
  private readonly api = `${environment.api_url}/party-halls`;
  constructor(private http: HttpClient) { }
  private headers = new HttpHeaders({
    'Content-Type': 'application/json',
  });
  private get httpOptions() {
    return { headers: this.headers };
  }

  getHalls(): Observable<PartyHall[]> {
    return this.http.get<PartyHall[]>(this.api+"/", this.httpOptions);
  }
  getHall(id: string): Observable<PartyHall> {
    return this.http.get<PartyHall>(`${this.api}/${id}`, this.httpOptions);
  }

  createHall(hall: PartyHall): Observable<PartyHall> {
    return this.http.post<PartyHall>(this.api, hall, this.httpOptions);
  }

  updateHall(id: number | undefined, hall: PartyHall): Observable<PartyHall> {
    return this.http.put<PartyHall>(`${this.api}/${id}`, hall, this.httpOptions);
  }

  deleteHall(id: number|undefined): Observable<void> {
    return this.http.delete<void>(`${this.api}/${id}`, this.httpOptions);
  }
}
