export class Permiso{

  constructor
  (
      public id: number,
      public tipo: string,
      public fecha: any,
      public fechai: any,
      public fechaf: any,
      public estado: string,
      public motivo: string,
      public dias: number,
      public empleado_id: number,
      public observaciones: string
  )
  {}
}
