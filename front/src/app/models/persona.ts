export class Persona{

  constructor
  (
      public id: number,
      public cedula: string,
      public nombre: string,
      public apellido: string,
      public fijo: string,
      public celular: string,
      public direccion: string,
      public municipio: string,
      public barrio: string,
      public fechanac: any,
      public estcivil: string,
      public email: string
  )
  {}
}
