export interface RoleProperties {
  id: number;
  name: string;
  status: boolean;
}

export interface RoleParams {
  q: string;
  perPage: number;
  currentPage: number;
}
