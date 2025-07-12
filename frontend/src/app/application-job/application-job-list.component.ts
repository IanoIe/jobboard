import { Component, inject, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-application-job-list',
  standalone: true,
  imports: [CommonModule, FormsModule, HttpClientModule],
  templateUrl: './application-job-list.component.html',
  styleUrls: ['./application-job-list.component.css']
})
export class ApplicationJobListComponent implements OnInit {
  httpClient = inject(HttpClient);
  applicationJobs: any[] = [];
  loading = true;

  ngOnInit(): void {
    this.fetchData();
  }

  fetchData(): void {
    this.httpClient.get('https://127.0.0.1:8000/api/application_jobs').subscribe(
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
