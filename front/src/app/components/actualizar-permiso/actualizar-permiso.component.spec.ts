import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ActualizarPermisoComponent } from './actualizar-permiso.component';

describe('ActualizarPermisoComponent', () => {
  let component: ActualizarPermisoComponent;
  let fixture: ComponentFixture<ActualizarPermisoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ActualizarPermisoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ActualizarPermisoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
