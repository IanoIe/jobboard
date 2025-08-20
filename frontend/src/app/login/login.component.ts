import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';


interface AuthResponse {
  token?: string;
}
@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './login.component.html'
})
export class LoginComponent {
  email = '';
  password = '';
  error = '';

  constructor(private http: HttpClient, private router: Router) {}

  async handleLoginSubmit(): Promise<void> {
    this.error = '';

    try {
      const res = await this.http.post<AuthResponse>(
        'https://api.jobboard.wip/auth',
        { email: this.email, password: this.password },
        { withCredentials: true }
      ).toPromise();

      if (res?.token) {
        localStorage.setItem('token', res.token);
        this.router.navigate(['/recruiter']);
      } else {
        this.error = 'Login failed: no token returned.';
      }
    } catch (err: any) {
      console.error(err);
      this.error = 'Invalid credentials or server error.';
    }
  }

  goToRegister() {
    this.router.navigate(['/register']);
  }
}

