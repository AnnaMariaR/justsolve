import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DebtService {

  private api: string = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  getDebts(): Observable<any> {
    return this.http.get(`${this.api}/debts`);
  }

  getDebt(id: number): Observable<any> {
    return this.http.get(`${this.api}/debts/${id}`);
  }

  getSuggestion(id: number): Observable<any> {
    return this.http.get(`${this.api}/debts/${id}/suggestion`);
  }

  applyAction(id: number, action: string): Observable<any> {
    return this.http.post(`${this.api}/debts/${id}/apply-action`, { action });
  }
}
