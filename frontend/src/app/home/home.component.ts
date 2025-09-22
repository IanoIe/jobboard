import { Component } from '@angular/core';
import { JobOfferListComponent } from '../job-offer/job-offer-list.component';

@Component({
  selector: 'app-home',
  imports: [JobOfferListComponent],
  templateUrl: './home.component.html'
})
export class Home {

}
