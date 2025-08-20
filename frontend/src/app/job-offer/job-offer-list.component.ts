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

    messages = [
    'You can apply for the latest job offers on our website!',
    'Check out new job offers every day!',
    'Apply now and get your dream job!',
    "Don't miss our latest job offers!"
  ];

  colors = [
  'text-danger',
  'text-success',
  'text-primary',
  'text-warning'   
  ];


  currentMessageIndex = 0;

  ngOnInit(): void {
    this.fetchData();

    setInterval(() => {
      this.currentMessageIndex = (this.currentMessageIndex + 1) % this.messages.length;
    }, 3000);
  }

  fetchData(): void {
    this.httpClient.get<JobOffer[]>('https://api.jobboard.wip/api/job_offers').subscribe(
      (response) => {
        this.jobOffers = response.map(job => {
          job.createdAt = this.datePipe.transform(job.createdAt, 'dd/MM/yyyy')!;
          return job;
        });
        this.loading = false;
      },
      (error) => {
        console.error('Error fetching job offers: ', error);
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

  onFileSelected(event: Event) {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
      this.application.cv = input.files[0];
    }
  }

  submitApplication() {
    if (this.application.fullName && this.application.email && this.application.cv && this.selectedJob) {
      const formData = new FormData();
      formData.append('fullName', this.application.fullName);
      formData.append('email', this.application.email);
      formData.append('cv', this.application.cv);
      formData.append('jobId', this.selectedJob.id.toString());

      this.httpClient.post('https://api.jobboard.wip/api/applications/upload', formData).subscribe({
        next: (response) => {
          console.log('Application submitted successfully!', response);
          alert('Application sent!');
          this.closeApplicationForm();
        },
        error: (error) => {
          console.error('Error submitting application:', error);
          alert('Error submitting application. See console for details.');
        }
      });
    } else {
      alert('Please fill in all fields.');
    }
  }
}
