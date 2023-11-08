export interface SiteProperties {
    id: number
    user_id: string
    name: string
    geographical_area_id: number
    address_line1: string
    address_line2: string
    address_line3: string
    address_line4: string
    district: string
    town: string
    postal_code: string
    county: string
    country: string
    geo_color: string
    region_id: number
    status: string
}

export interface SiteParams {
    q: string,
    status: string,
    perPage: number,
    currentPage: number,
}