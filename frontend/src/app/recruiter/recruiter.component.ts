import { Component, OnInit } from '@angular/core';
import { JobOffer, JobOfferService, NewJobOffer } from '../service/job-offer.service';
import { CommonModule } from '@angular/common';
import { HttpErrorResponse } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-recruiter',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './recruiter.component.html',
  styleUrls: ['./recruiter.component.css']
})
export class RecruiterComponent implements OnInit {
  jobOffers: JobOffer[] = [];
  errorMessage: string | null = null;
  successMessage: string | null = null;
  user: any;
  showForm = false;

  newOffer: NewJobOffer = {
    nomEnterprise: '',
    title: '',
    typeContract: '',
    description: '',
    createdAt: new Date().toISOString(),
  };

  constructor(private jobOfferService: JobOfferService) {}

  ngOnInit(): void {
    this.jobOfferService.getMyJobOffers().subscribe({
      next: (offers: JobOffer[]) => this.jobOffers = offers,
      error: (err: any) => {
        this.errorMessage = 'Failed to load job offers. Please try again later.';
        console.error('Error loading job offers:', err);
      }
    });
    this.jobOfferService.getUserInfo().subscribe({
      next: (data) => {
        this.user = data;
      },
      error: (err) => {
        console.error('Error loading user information', err);
      }
    });
  }

  addOffer(): void {
    const offerToCreate: NewJobOffer = {
      nomEnterprise: this.newOffer.nomEnterprise,
      title: this.newOffer.title,
      typeContract: this.newOffer.typeContract,
      description: this.newOffer.description,
      createdAt: new Date().toISOString(),
    };

    this.jobOfferService.createJobOffer(offerToCreate).subscribe({
      next: (response: JobOffer) => {
        console.log('New offer created successfully:', response);
        this.jobOffers.push(response);
        this.successMessage = 'Job offer created successfully!';
      },
      error: (err) => {
        console.error('Error creating offer:', err);
        this.errorMessage = 'Failed to create job offer. Please try again later.';
      }
    });
  }

  updateOffer(offer: JobOffer): void {
    if (offer.id) {
      const updatedOffer = {
        ...offer,
        title: 'Updated Title',
      };

      this.jobOfferService.updateJobOffer(offer.id, updatedOffer).subscribe({
        next: (response: JobOffer) => {
          console.log('Offer updated successfully:', response);
          const index = this.jobOffers.findIndex(o => o.id === offer.id);
          if (index !== -1) {
            this.jobOffers[index] = response;
          }
          this.successMessage = 'Job offer updated successfully!';
        },
        error: (err) => {
          console.error('Error updating offer:', err);
          this.errorMessage = 'Failed to update job offer. Please try again later.';
        }
      });
    } else {
      console.error('Attempted to update an offer without an ID.');
      this.errorMessage = 'Cannot update offer without an ID.';
    }
  }

  deleteOffer(offer: JobOffer): void {
    if (offer.id) {
      this.jobOfferService.deleteJobOffer(offer.id).subscribe({
        next: () => {
          console.log('Offer deleted successfully');
          this.jobOffers = this.jobOffers.filter(o => o.id !== offer.id);
          this.successMessage = 'Job offer deleted successfully!';
        },
        error: (err: HttpErrorResponse) => {
          console.error('Error deleting offer:', err);
          this.errorMessage = 'Failed to delete job offer. Please try again later.';
        }
      });
    } else {
      console.error('Attempted to delete an offer without an ID.');
      this.errorMessage = 'Cannot delete offer without an ID.';
    }
  }
}
