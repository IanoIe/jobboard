import { Component, OnInit } from '@angular/core';
import { JobOffer, JobOfferService } from '../service/job-offer.service';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-recruiter',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './recruiter.component.html',
  styleUrls: ['./recruiter.component.css']
})
export class RecruiterComponent implements OnInit {
  jobOffers: JobOffer[] = [];
  errorMessage: string | null = null;
  user: any;

  constructor(
    private jobOfferService: JobOfferService) {}

  ngOnInit(): void {
    this.jobOfferService.getMyJobOffers().subscribe({
      next: (offers: JobOffer[]) => this.jobOffers = offers, error: (err: any) => {
        this.errorMessage = 'Failed to load job offers. Please try again later.';
        console.error('Error loading job offers:', err);
      }
    });

    this.jobOfferService.getUserInfo().subscribe({
      next: (data) => {
        this.user = data;
      },
      error: (err) => {
        console.error('Error loading user information', err)
      }
    });
  }
}

