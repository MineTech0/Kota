import axios from "axios"

const deleteFile =  async (id: number) => {
    const response = await axios.delete(`/files/${id}`)
    return response.data
}

const FileService = {
    deleteFile
}

export default FileService