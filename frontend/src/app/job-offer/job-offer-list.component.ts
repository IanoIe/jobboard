import { Component, inject, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
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
    this.httpClient.get<JobOffer[]>('https://127.0.0.1:8000/api/job_offers').subscribe(
      (data: JobOffer[]) => {
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
