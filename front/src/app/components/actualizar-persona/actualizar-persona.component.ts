import { Component, OnInit } from '@angular/core';
import { Persona } from 'src/app/models/persona';
import { PersonaServices } from 'src/app/services/persona.services';
import { UserServices } from 'src/app/services/user.services';
import { global } from 'src/app/services/global';
import { Router, ActivatedRoute, Params } from '@angular/router';

@Component({
  selector: 'app-actualizar-persona',
  templateUrl: './actualizar-persona.component.html',
  styleUrls: ['./actualizar-persona.component.css'],
  providers:[PersonaServices,UserServices]
})
export class ActualizarPersonaComponent implements OnInit
{

  public page_title: string;
  public url = global.url;
  public persona:Persona;
  public token;
  public status: string;
  public mensaje: string;

  constructor
  (
    private _personaService: PersonaServices,
    private _userService: UserServices,
    private _route: ActivatedRoute,
    private _router: Router,
  )
  {
    this.page_title='Actualizar Personas'
    this.token = this._userService.getToken();
    this.url = global.url;
    this.persona = new Persona(1,'','','','','','','','','','','');
    this.status = '';
    this.mensaje='';
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
    this._personaService.update(this.token,this.persona,this.persona.id).subscribe
    (
      response=>
      {
          this.status = 'success';
          this.mensaje = response.message;

          if(response.actualizado.nombre)
          {
            this.persona.nombre = response.actualizado.nombre;
          }
          if(response.actualizado.apellido)
          {
            this.persona.apellido = response.actualizado.apellido;
          }
          if(response.actualizado.direccion)
          {
            this.persona.direccion = response.actualizado.direccion;
          }
          if(response.actualizado.barrio)
          {
            this.persona.barrio = response.actualizado.barrio;
          }
          if(response.actualizado.email)
          {
            this.persona.email = response.actualizado.email;
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
        this._personaService.show(this.token,id).subscribe
        (
          response=>
          {
            this.persona = response.persona;
          },
          error=>
          {
            console.log(error);
          }
        );
      }
    );
  }

}
