
class CategoryService {

    constructor(axios){
        this.axios = axios
        this.endpoint = 'api/category'
    }
    async getAll(options){
        try {
            let request = await this.axios.get(`${this.endpoint}?page=${options.page}&perpage=${options.itemsPerPage}`)
            return request.data
        } catch (error) {
            throw new Error('Error obteniendo categorías')
        }
    }
    async post(payload){
        try {
            let request = await this.axios.post(`${this.endpoint}`, payload)
            return request.data
        } catch (error) {
            throw new Error('Error guardando categoría')
        }
    }
    async edit(payload, id){
        try {
            let request = await this.axios.put(`${this.endpoint}/${id}`, payload)
            return request.data
        } catch (error) {
            throw new Error('Error editando categoría')
        }
    }
    async delete(id){
        try {
            let request = await this.axios.delete(`${this.endpoint}/${id}`)
            return request.data
        } catch (error) {
            throw new Error('Error editando categoría')
        }
    }
}

export default CategoryService
