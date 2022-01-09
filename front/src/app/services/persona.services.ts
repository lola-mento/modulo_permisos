import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { Persona } from "../models/persona";
import { global } from "./global";

@Injectable()
export class PersonaServices
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
      return this._http.get(this.url+'persona',{headers:headers});
  }
  buscar(token:any,bq:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.get(this.url+'persona/buscar/'+bq,{headers:headers});
  }
  destroy(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.delete(this.url+'persona/'+id,{headers:headers});
  }
  store(token:any,persona:any): Observable<any>
  {
    let json = JSON.stringify(persona);
    let params = 'json='+json;
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.post(this.url+'persona', params, {headers:headers});
  }
  update(token:any,persona:any,id:any): Observable<any>
  {
    let json = JSON.stringify(persona);
    let params = 'json='+json;
    let headers = new HttpHeaders()
                                  .set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.put(this.url+'persona/'+id, params, {headers:headers});
  }
  show(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                    .set('Authorization',token);
    return this._http.get(this.url+'persona/'+id,{headers:headers});
  }


}

