import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, catchError, throwError } from 'rxjs';
import { error } from 'console';

export interface JobOffer {
  id: number;
  nomEnterprise: string;
  title: string;
  typeContract: string;
  description: string;
  createdAt: string;
}

@Injectable({
  providedIn: 'root',
})
export class JobOfferService {
  private apiUrl = 'https://api.jobboard.wip/api/job-offers/mine';
  private userApiUrl = 'https://api.jobboard.wip/api/me';

  constructor(private http: HttpClient) {}

  getMyJobOffers(): Observable<JobOffer[]> {
    const token = localStorage.getItem('token');
    return this.http.get<JobOffer[]>(this.apiUrl, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    }).pipe(
      catchError(error => {
        console.error('Error loading job offers', error);
        throw error;
      })
    );
  }

  getUserInfo(): Observable<any> {
    const token = localStorage.getItem('token');
    return this.http.get<any>(this.userApiUrl, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }).pipe(
      catchError(error => {
        console.error('Error loading user info', error);
        return throwError(() => error);
      })
    );
  }
}
