class BookService {
    constructor(axios){
        this.axios = axios
        this.endpoint = 'api/book'
    }

    async getAll( options, filter ){
        try {
            const filterString = filter !== null ? `&search=${filter}` : ''
            let request = await this.axios.get(`${this.endpoint}?page=${options.page}&perpage=${options.itemsPerPage}${filterString}`)
            return request.data
        } catch (error) {
            throw new Error(' Cant get books ')
        }
    }
    async post(payload){
        try {
            await this.axios.post(this.endpoint, payload)
        } catch (error) {
            throw new Error('Cant save book')
        }
    }
    async update(payload, id){
        try {
            await this.axios.put(`${this.endpoint}/${id}`, payload)
        } catch (error) {
            throw new Error('Cant update book')
        }
    }
    async delete(id){
        try {
            await this.axios.delete(`${this.endpoint}/${id}`)
        } catch (error) {
            throw new Error('Cant delete book')
        }
    }
}

export default BookService
