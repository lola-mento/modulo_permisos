import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { Persona } from "../models/persona";
import { global } from "./global";

@Injectable()
export class PermisoServices
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
      return this._http.get(this.url+'permiso',{headers:headers});
  }
  buscar(token:any,bq:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.get(this.url+'permiso/buscar/'+bq,{headers:headers});
  }
  destroy(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.delete(this.url+'permiso/'+id,{headers:headers});
  }
  store(token:any,permiso:any): Observable<any>
  {
    let json = JSON.stringify(permiso);
    let params = 'json='+json;
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.post(this.url+'permiso', params, {headers:headers});
  }
  update(token:any,permiso:any,id:any): Observable<any>
  {
    let json = JSON.stringify(permiso);
    let params = 'json='+json;
    let headers = new HttpHeaders()
                                  .set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.put(this.url+'permiso/'+id, params, {headers:headers});
  }
  show(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                    .set('Authorization',token);
    return this._http.get(this.url+'permiso/'+id,{headers:headers});
  }


}

