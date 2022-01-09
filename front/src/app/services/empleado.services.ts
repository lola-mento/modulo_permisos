import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { Persona } from "../models/persona";
import { global } from "./global";

@Injectable()
export class EmpleadoServices
{
  public url:string;
  constructor
  (
    public _http: HttpClient
  )
  {
    this.url = global.url;
  }
  index(token:any):Observable<any>
  {
      let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                    .set('Authorization',token);
      return this._http.get(this.url+'empleado',{headers:headers});
  }
  buscar(token:any,bq:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.get(this.url+'empleado/buscar/'+bq,{headers:headers});
  }
  destroy(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.delete(this.url+'empleado/'+id,{headers:headers});
  }
  store(token:any,empleado:any): Observable<any>
  {
    let json = JSON.stringify(empleado);
    let params = 'json='+json;
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.post(this.url+'empleado', params, {headers:headers});
  }
  update(token:any,empleado:any,id:any): Observable<any>
  {
    let json = JSON.stringify(empleado);
    let params = 'json='+json;
    let headers = new HttpHeaders()
                                  .set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.put(this.url+'empleado/'+id, params, {headers:headers});
  }
  show(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                    .set('Authorization',token);
    return this._http.get(this.url+'empleado/'+id,{headers:headers});
  }


}

