export interface ServiceRequestTypeProperties {
  id: number
  type_name:string
  minimum_images_required:number
  status: string
}

export interface ServiceRequestTypeParams {
  q: string,
  status: string,
  perPage: number,
  currentPage: number,
}
 