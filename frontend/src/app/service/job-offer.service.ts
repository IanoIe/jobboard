import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, catchError, throwError } from 'rxjs';

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
}
