import { Component, OnInit } from '@angular/core';
import { CargoServices } from 'src/app/services/cargo.services';
import { AreaServices } from 'src/app/services/area.services';
import { EmpleadoServices } from 'src/app/services/empleado.services';
import { PermisoServices } from 'src/app/services/permiso.services';
import { UserServices } from 'src/app/services/user.services';
import { Permiso } from 'src/app/models/permiso';
import { global } from 'src/app/services/global';
import { NgbDateStruct } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'permiso',
  templateUrl: './permiso.component.html',
  styleUrls: ['./permiso.component.css'],
  providers: [CargoServices,AreaServices,EmpleadoServices,PermisoServices,UserServices]
})
export class PermisoComponent implements OnInit
{
    public page_title: string;
    public url = global.url;
    public permiso:Permiso;
    public resultado:any;
    public resultadoEmpleado:any;
    public resultadoArea:any;
    public resultadoCargo:any;
    public bq:any;
    public status: string;
    public mensaje: string;
    public token;
    public p:any;

  constructor
  (
    private _cargoService: CargoServices,
    private _areaService: AreaServices,
    private _empleadoService: EmpleadoServices,
    private _permisoService: PermisoServices,
    private _userService: UserServices
  )
  {
    this.page_title = 'Gestión de permisos';
    this.permiso = new Permiso(1,'','','','','','',1,1,'');
    this.status = '';
    this.mensaje = '';
    this.token = this._userService.getToken();
  }

  ngOnInit(): void
  {
    this.index();
    this.getEmpleados();
  }

  store(form:any)
  {
    this._permisoService.store(this.token,this.permiso).subscribe
    (
      response =>
      {
        if(response.status = "success")
        {
          this.status = response.status;
          this.mensaje = response.message;
          form.reset();
          this.index();
        }
        else
        {
          this.status = 'error';
          this.mensaje = response.message;
        }

      },
      error=>
      {
        this.status = 'error';
        this.mensaje = error.error.message;
      }
    );
  }
  index()
  {
    this._permisoService.index(this.token).subscribe
    (
      response=>
      {
        if(response.status = 'success')
        {
          this.resultado = response.permiso;
        }
      },
      error=>
      {
        this.mensaje = error.message;
      }
    )
  }
  reload()
  {
    window.location.reload();
  }
  destroy(id:any)
  {
    this._permisoService.destroy(this.token,id).subscribe
    (
      response=>
      {
        this.status = response.status;
        this.mensaje = response.message;
        setTimeout('document.location.reload()',500);


      },
      error=>
      {
        this.mensaje = error.message;
      }
    )
  }
  getEmpleados()
  {
    this._empleadoService.index(this.token).subscribe
    (
      response=>
      {
        if(response.status = 'success')
        {
          this.resultadoEmpleado = response.empleado;
        }
      },
      error=>
      {
        this.mensaje = error.message;
      }
    )
  }
  getAreas()
  {
    this._areaService.index(this.token).subscribe
    (
      response=>
      {
        if(response.status = 'success')
        {
          this.resultadoArea = response.area;
        }
      },
      error=>
      {
        this.mensaje = error.message;
      }
    )
  }
  getCargos()
  {
    this._cargoService.index(this.token).subscribe
    (
      response=>
      {
        if(response.status = 'success')
        {
          this.resultadoCargo = response.cargo;
        }
      },
      error=>
      {
        this.mensaje = error.message;
      }
    )
  }

}
