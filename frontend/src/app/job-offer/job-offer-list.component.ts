import { Component, inject, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';

interface JobOffer {
  id: number;
  title: string;
  nomEnterprise: string;
  typeContract: string;
  description: string;
}

@Component({
  selector: 'app-job-offer-list',
  standalone: true,
  imports: [CommonModule, FormsModule, HttpClientModule],
  templateUrl: './job-offer-list.component.html',
  styleUrls: ['./job-offer-list.component.css']
})
export class JobOfferListComponent implements OnInit {
  httpClient = inject(HttpClient);
  jobOffers: JobOffer[] = [];
  loading = true;

  ngOnInit(): void {
    this.fetchData();
  }

  fetchData(): void {
    const token = localStorage.getItem('token');
    let headers = new HttpHeaders();

    if (token) {
      headers = headers.set('Authorization', `Bearer ${token}`);
    }
    this.httpClient.get<JobOffer[]>('https://api.jobboard.wip/api/job_offers', { headers }).subscribe(
      (data) => {
        this.jobOffers = data;
        this.loading = false;
      },
      (error) => {
        console.error('Error searching for job offer: ', error);
        this.loading = false;
      }
    );
  }
}
