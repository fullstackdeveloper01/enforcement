  export interface RoleRightProperties {
    category:string,
    status:boolean,
  }
  
  export interface RoleRightParams {
    q: string;
    perPage: number,
    currentPage: number,
    role:number,
    status:string
  }