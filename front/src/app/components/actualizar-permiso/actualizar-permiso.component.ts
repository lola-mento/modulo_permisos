import { Component, OnInit } from '@angular/core';
import { Permiso } from 'src/app/models/permiso';
import { PermisoServices } from 'src/app/services/permiso.services';
import { UserServices } from 'src/app/services/user.services';
import { global } from 'src/app/services/global';
import { Router, ActivatedRoute, Params } from '@angular/router';

@Component({
  selector: 'app-actualizar-permiso',
  templateUrl: './actualizar-permiso.component.html',
  styleUrls: ['./actualizar-permiso.component.css'],
  providers:[PermisoServices,UserServices]
})
export class ActualizarPermisoComponent implements OnInit
{
  public page_title: string;
  public url = global.url;
  public permiso:Permiso;
  public token;
  public status: string;
  public mensaje: string;
  public nombre: string;
  public apellido: string;

  constructor
  (
    private _permisoService: PermisoServices,
    private _userService: UserServices,
    private _route: ActivatedRoute,
    private _router: Router,
  )
  {
    this.page_title='Editar permisos'
    this.token = this._userService.getToken();
    this.url = global.url;
    this.permiso = new Permiso(1,'','','','','','',1,1,'');
    this.status = '';
    this.mensaje='';
    this.nombre='';
    this.apellido='';
  }

  ngOnInit(): void
  {
    this.show();
  }
  reload()
  {
    window.location.reload();
  }
  //! MÉTODO QUE SE EJECUTA AL OPRIMIR EL BOTON SUBMIT
  onSubmit(form:any)
  {
    this._permisoService.update(this.token,this.permiso,this.permiso.id).subscribe
    (
      response=>
      {
          this.status = 'success';
          this.mensaje = response.message;

          if(response.actualizado.tipo)
          {
            this.permiso.tipo = response.actualizado.tipo;
          }
          if(response.actualizado.motivo)
          {
            this.permiso.motivo = response.actualizado.motivo;
          }
          if(response.actualizado.fechai)
          {
            this.permiso.fechai = response.actualizado.fechai;
          }
          if(response.actualizado.fechaf)
          {
            this.permiso.fechaf = response.actualizado.fechaf;
          }
          if(response.actualizado.observaciones)
          {
            this.permiso.observaciones = response.actualizado.observaciones;
          }
      },
      error=>
      {
        this.mensaje=error.message;
      }
    )
  }
  //!MÉTODO PARA MOSTRAR UN SOLO POST
  show()
  {
    //Sacamos el ID del post que quiero sacar
    this._route.params.subscribe
    (
      params=>
      {
        let id = +params['id'];
        //Petición AJAX para sacar los datos del POST.
        this._permisoService.show(this.token,id).subscribe
        (
          response=>
          {
            this.permiso = response.permiso;
            this.nombre = response.permiso.nombre;
            this.apellido = response.permiso.apellido;
          },
          error=>
          {
            this.mensaje = error.message;
          }
        );
      }
    );
  }

}
