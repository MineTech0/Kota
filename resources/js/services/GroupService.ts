import axios from "axios";
import { GroupForm } from "../types";

const storeGroup = async (newGroup: GroupForm) => {
    const response = await axios.post('/groups',newGroup)
    return response.data    
}

const updateGroup = async (id: number, newGroup: GroupForm) => {
    const response = await axios.put(`/groups/${id}`,newGroup)
    return response.data
}

const deleteGroup = async (id: number) => {
    const response = await axios.delete(`/groups/${id}`)
    return response.data
}

const GroupService = {
    storeGroup,
    updateGroup,
    deleteGroup
}

export default GroupService;
