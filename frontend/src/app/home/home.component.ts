import { Component } from '@angular/core';
import { Navbar } from '../navbar/navbar.component';
import { JobOfferListComponent } from '../job-offer/job-offer-list.component';

@Component({
  selector: 'app-home',
  imports: [Navbar, JobOfferListComponent],
  templateUrl: './home.component.html'
})
export class Home {

}
