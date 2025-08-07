import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, catchError, throwError } from 'rxjs';
import { error } from 'node:console';

export interface NewJobOffer {
  nomEnterprise: string;
  title: string;
  typeContract: string;
  description: string;
  createdAt: string;
}
export interface JobOffer extends NewJobOffer {
  id: number;
}

@Injectable({
  providedIn: 'root',
})
export class JobOfferService {
  private apiUrl = 'https://api.jobboard.wip/api/job-offers/mine';
  private userApiUrl = 'https://api.jobboard.wip/api/me';
  private createApiUrl = 'https://api.jobboard.wip/api/job_offers';


  constructor(private http: HttpClient) {}

  getMyJobOffers(): Observable<JobOffer[]> {
    const token = localStorage.getItem('token');
    return this.http.get<JobOffer[]>(this.apiUrl, {
      headers: {
        Authorization: `Bearer ${token}`,
      }
    }).pipe(
      catchError(error => {
        console.error('Error loading job offers', error);
        return throwError(() => error);
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

  addJobOffer(jobOfferData: NewJobOffer): Observable<JobOffer> {
    const token = localStorage.getItem('token');
    return this.http.post<JobOffer>(this.createApiUrl, jobOfferData, {
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
      }
    }).pipe(
      catchError(error => {
        console.error('Error creating job offer: ', error);
        return throwError(() => error);
      })
    );
  }

  updateJobOffer(id: number, jobOfferData: Partial<JobOffer>): Observable<JobOffer> {
    const url = `https://api.jobboard.wip/api/job_offers/${id}`;
    const token = localStorage.getItem('token');

    return this.http.patch<JobOffer>(url, jobOfferData, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/merge-patch+json'
      }
    });
  }

  deleteJobOffer(id: number): Observable<void> {
    const token = localStorage.getItem('token');
    const url = `https://api.jobboard.wip/api/job_offers/${id}`;
    console.log('Calling DELETE on URL:', url);
    return this.http.delete<void>(url, {
      headers: { Authorization: `Bearer ${token}` }
    });
  }
}
