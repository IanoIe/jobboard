import { Component, OnInit } from '@angular/core';
import { JobOffer, JobOfferService, NewJobOffer } from '../service/job-offer.service';
import { CommonModule } from '@angular/common';
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
  editingOffer: JobOffer | null = null;

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

    this.jobOfferService.addJobOffer(offerToCreate).subscribe({
      next: (response: JobOffer) => {
        console.log('New offer created successfully:', response);
        this.jobOffers.push(response);
        this.successMessage = 'Job offer created successfully!';

        this.showForm = false;
        this.newOffer = {
          nomEnterprise: '',
          title: '',
          typeContract: '',
          description: '',
          createdAt: '',
        };
      },
      error: (err) => {
        console.error('Error creating offer:', err);
        this.errorMessage = 'Failed to create job offer. Please try again later.';
      }
    });
  }

  startEditing(offer: JobOffer): void {
    this.editingOffer = {...offer };
  }
  cancelEditing(): void {
    this.editingOffer = null;
  }

  submitUpdate(): void {
    if (!this.editingOffer || !this.editingOffer.id) return;

    const { id, ...dataToUpdate } = this.editingOffer;

    this.jobOfferService.updateJobOffer(id, dataToUpdate).subscribe({
      next: (updatedOffer) => {
        const index = this.jobOffers.findIndex(o => o.id === id);
        if (index !== -1) {
          this.jobOffers[index] = updatedOffer;
        }
        this.successMessage = 'Offer updated successfully!';
        this.editingOffer = null;
      },
      error: (err) => {
        console.error('Error updating offer:', err);
        this.errorMessage = 'Error updating offer.';
      }
    });
  }

  deleteOffer(offer: JobOffer): void {
    const confirmDelete = confirm(`Are you sure you want to delete the job offer "${offer.title}"?`);

    if (!confirmDelete) {
      return;
    }
    if (!offer.id) {
      this.errorMessage = 'Offer ID is missing.';
      return;
    }

    this.jobOfferService.deleteJobOffer(offer.id).subscribe({
      next: () => {
        this.jobOffers = this.jobOffers.filter(o => o.id !== offer.id);
        this.successMessage = 'Job offer deleted successfully!';
        this.cancelEditing();
      },
      error: err => {
        console.error('Error deleting offer:', err);
        this.errorMessage = 'Failed to delete job offer.';
      }
    });
  }

}
