import axios from "axios";
import { GroupForm } from "../types";

const storeGroup = async (newGroup: GroupForm) => {
    const response = await axios.post('/groups',newGroup)
    return response.data    
}

const GroupService = {
    storeGroup
}

export default GroupService;
