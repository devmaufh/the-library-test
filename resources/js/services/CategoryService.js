
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
            throw new Error('Cant get categories')
        }
    }
    async post(payload){
        try {
            await this.axios.post(`${this.endpoint}`, payload)
        } catch (error) {
            throw new Error('Cant save category')
        }
    }
    async edit(payload, id){
        try {
            await this.axios.put(`${this.endpoint}/${id}`, payload)
        } catch (error) {
            throw new Error('Cant update category')
        }
    }
    async delete(id){
        try {
            await this.axios.delete(`${this.endpoint}/${id}`)
        } catch (error) {
            throw new Error('Cant delete category')
        }
    }
}

export default CategoryService
