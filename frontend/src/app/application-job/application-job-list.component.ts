import { Component, inject, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { FormsModule } from '@angular/forms';


@Component({
  selector: 'app-application-job-list',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './application-job-list.component.html'
})

export class ApplicationJobListComponent implements OnInit {
  httpClient = inject(HttpClient);
  applicationJobs: any[] = [];
  loading = true;

  ngOnInit(): void {
    this.fetchData();
  }

  fetchData(): void {
    this.httpClient.get('https://api.jobboard.wip/api/application_jobs').subscribe(
      (data: any) => {
        this.applicationJobs = data;
        this.loading = false;
      },
      (error) => {
        console.error('Error searching for application jobs:', error);
        this.loading = false;
      }
    );
  }
}
