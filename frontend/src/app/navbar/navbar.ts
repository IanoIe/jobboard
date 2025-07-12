import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component, inject, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterLink, CommonModule, FormsModule, HttpClientModule],
  templateUrl: './navbar.html',
  styleUrl: './navbar.css'
})
export class Navbar implements OnInit {
  httpClient = inject(HttpClient);
  data: any[] = [];

  ngOnInit(): void {
    this.fetchData();
  }

  fetchData() {
    this.httpClient.get<any[]>('https://127.0.0.1:8000/api/job_offers').subscribe((data: any[]) => {
      this.data = data;
    });
  }

  applyForJob(offer: any): void {
    const candidateData = {
      jobId: offer.id,
      userId: 1,  
      appliedAt: new Date()
    };

    // Envia a candidatura para o backend (Symfony)
    this.httpClient.post('https://127.0.0.1:8000/api/candidates', candidateData)
      .subscribe(
        response => {
          alert('Candidatura enviada com sucesso!');
        },
        error => {
          alert('Erro ao enviar candidatura');
        }
      );
  }
}
