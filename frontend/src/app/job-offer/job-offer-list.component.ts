import { Component, inject, OnInit } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { CommonModule, DatePipe } from '@angular/common';
import { FormsModule } from '@angular/forms';

interface JobOffer {
  id: number;
  title: string;
  nomEnterprise: string;
  typeContract: string;
  description: string;
  createdAt: string;
}

@Component({
  selector: 'app-job-offer-list',
  standalone: true,
  imports: [CommonModule, FormsModule, HttpClientModule],
  templateUrl: './job-offer-list.component.html',
  styleUrls: ['./job-offer-list.component.css'],
  providers: [DatePipe]
})
export class JobOfferListComponent implements OnInit {
  httpClient = inject(HttpClient);
  datePipe = inject(DatePipe);
  jobOffers: JobOffer[] = [];
  loading = true;
  selectedJob: JobOffer | null = null;
  application = {
    fullName: '',
    email: '',
    cv: null as File | null
  };

  ngOnInit(): void {
    this.fetchData();
  }

  fetchData(): void {
    this.httpClient.get<JobOffer[]>('https://127.0.0.1:8000/api/job_offers').subscribe(
      (response) => {
        console.log('Complete answer: ', response);
        this.jobOffers = response.map(job => {
          job.createdAt = this.datePipe.transform(job.createdAt, 'dd/MM/yyyy')!;
          return job;
        });
        this.loading = false;
      },
      (error) => {
        console.error('Error searching for job vacancies: ', error);
        this.loading = false;
      }
    );
  }

  openApplicationForm(job: JobOffer) {
    this.selectedJob = job;
  }

  closeApplicationForm() {
    this.selectedJob = null;
    this.application = {
      fullName: '',
      email: '',
      cv: null
    };
  }

  submitApplication() {
    if (this.application.fullName && this.application.email && this.application.cv) {
      const formData = new FormData();
      formData.append('fullName', this.application.fullName);
      formData.append('email', this.application.email);
      formData.append('cv', this.application.cv!);
      formData.append('jobId', this.selectedJob!.id.toString());

      console.log('Application ready to send: ');
      console.log('Job:', this.selectedJob);
      console.log('FormData:', this.application);

      this.closeApplicationForm();
    } else {
      alert('Please fill in all fields.');
    }
  }
}
