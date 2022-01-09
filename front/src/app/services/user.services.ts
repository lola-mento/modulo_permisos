import { Injectable } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { HttpHeaders } from "@angular/common/http";
import { Observable } from "rxjs";
import { global } from "./global";


@Injectable()
export class UserServices
{

  public url: string;
  public identity:any;
  public token:any;

  constructor
  (
    public _http: HttpClient
  )
  {
    this.url = global.url;
  }
  //! METODOS DEL CRUD DE USUARIOS
  store(token:any,user:any): Observable<any>
  {
    let json = JSON.stringify(user);
    let params = 'json='+json;
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                    .set('Authorization',token);
    return this._http.post(this.url+'user', params, {headers:headers});
  }
  index(token:any):Observable<any>
  {
      let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                    .set('Authorization',token);
      return this._http.get(this.url+'user',{headers:headers});
  }
  buscar(token:any,bq:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.get(this.url+'user/buscar/'+bq,{headers:headers});
  }
  destroy(token:any,id:any):Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded')
                                  .set('Authorization',token);
    return this._http.delete(this.url+'user/'+id,{headers:headers});
  }

  //!METODOS PARA AUTENTICACION DE USUARIOS
  signup(user:any, getToken:any = null): Observable<any>
  {
    if(getToken != null)
    {
      user.getToken = 'true';
    }
    let json = JSON.stringify(user);
    let params = 'json='+json;
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded');
    return this._http.post(this.url+'user/login', params, {headers:headers});
  }
  getIdentity()
  {
    let identity = JSON.parse(localStorage.getItem('identity')||'{}');
    if(identity && identity != "undefined")
    {
        this.identity = identity;
    }
    else
    {
      this.identity = null;
    }
    return this.identity;
  }
  getToken()
  {
    let token = localStorage.getItem('token');
    if(token != 'undefined')
    {
      this.token = token;
    }
    else
    {
      this.token = null;
    }
    return this.token;
  }
  getUser(id:any): Observable<any>
  {
    let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded');
    return this._http.get(this.url+'users/details/'+id, {headers:headers});
  }




}
