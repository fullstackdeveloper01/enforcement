export interface RepresentaionProperties {
  id: number
  englishName: string
  welshName: string
  type: string
  status: string
}

export interface RepresentaionParams {
  q?: string,
  status: string,
  lodgeDate:string,
  council:Array,
  perPage?: number,
  currentPage?: number,
}


export interface StatItemParams {
  title: string;
  color: string;
  icon: string;
  stats: number;
};