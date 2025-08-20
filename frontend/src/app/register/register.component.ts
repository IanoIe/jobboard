import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { catchError } from 'rxjs/operators';
import { NgForm } from '@angular/forms';
import { of } from 'rxjs';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './register.component.html'
})

export class RegisterComponent {
  firstName = '';
  lastName = '';
  email = '';
  password = '';
  confirmPassword = '';
  role = 'Recruiter';
  error = '';

  constructor(private http: HttpClient, private router: Router) {}

  handleRegisterSubmit(registerForm: NgForm): void {
  if (!registerForm.valid) {
    this.error = 'Please fill in all required fields.';
    return;
  }

  if (this.password !== this.confirmPassword) {
    this.error = 'Passwords do not match.';
    return;
  }

  const payload = {
    firstName: this.firstName,
    lastName: this.lastName,
    email: this.email,
    password: this.password,
    role: this.role
  };

  this.http.post<any>('https://api.jobboard.wip/api/register', payload)
    .pipe(
      catchError((err) => {
        this.error = 'Registration failed. Please try again later.';
        console.error('Registration error:', err);
        return of(null);
      })
    )
    .subscribe({
      next: (response) => {
        if (response) {
          this.router.navigate(['/login']);
        }
      },
      error: () => {
        this.error = 'An unexpected error occurred. Please try again later.';
      }
    });
}

}
