import { Component, inject, OnInit } from '@angular/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';


interface User {
  id: number;
  firstname: string;
  lastname: string;
  email: string;
  roles: string[];
}

@Component({
  selector: 'app-user-list',
  standalone: true,
  imports: [CommonModule, FormsModule, HttpClientModule],
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.css']
})
export class UserListComponent implements OnInit {
  httpClient = inject(HttpClient);
  users: User[] = [];
  loading = true;

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers(): void {
    this.httpClient.get<User[]>('https://127.0.0.1:8000/api/users').subscribe(
      (data) => {
        this.users = data;
        this.loading = false;
      },
      (error) => {
        console.error('Error searching for users', error);
        this.loading = false;
      }
    );
  }
}
