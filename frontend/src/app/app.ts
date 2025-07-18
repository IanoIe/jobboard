import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { Navbar } from './navbar/navbar';
import { JobOfferListComponent } from './job-offer/job-offer-list.component';
import { Footer } from './footer/footer';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterModule, Navbar, JobOfferListComponent, Footer],
  template: `
    <router-outlet></router-outlet>
    <app-job-offer-list></app-job-offer-list>
    <app-footer></app-footer>`
})
export class AppComponent {}
