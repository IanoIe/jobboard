import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ApplicationJobListComponent } from './application-job-list.component';

describe('ApplicationJobListComponent', () => {
  let component: ApplicationJobListComponent;
  let fixture: ComponentFixture<ApplicationJobListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ApplicationJobListComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ApplicationJobListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
