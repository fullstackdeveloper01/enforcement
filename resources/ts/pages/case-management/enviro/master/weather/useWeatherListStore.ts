import type { WeatherParams, WeatherProperties } from '@/pages/case-management/enviro/master/weather/types'
import axios from '@axios'
import { defineStore } from 'pinia'

export const useWeatherListStore = defineStore('WeatherListStore', {
  actions: {

    // 👉 Fetch weather data
    fetchWeatherItems(params: WeatherParams) { return axios.get('/api/enviro/master/weather', { params }) },

    // 👉 Add weather
    addWeather(Data: Partial<WeatherProperties>) {
        delete Data.id;
        delete Data.status;
        return  axios.post('/api/enviro/master/weather', 
          Data
        )
    },

    // 👉 Update weather status
   updateWeatherStatus(id:number,status:string) {
      return axios.put('/api/enviro/master/weather/'+id+'/status', 
      {status:status}
    )
    },

    // 👉 Update weather
    updateWeather(Data: Partial<WeatherProperties>) {
      let id=Data.id
      delete Data.id;
      delete Data.status;
      return axios.put('/api/enviro/master/weather/'+id, 
      Data
    )
    },
    
  },
})
