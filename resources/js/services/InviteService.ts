import { Invite } from "@/types"
import axios from "axios"

const sendInvite = async (email:string) => {
    const response = await axios.post('/invite',{email})
    return response.data   
}
const resendInvite = async (invite: Invite) => {
    const response = await axios.post('/invite/resend',{...invite})
    return response.data
}

const deleteInvite = async (inviteId: number) => {
    const response = await axios.delete('/invite/'+inviteId)
    return response.data
}


const InviteService = {
    sendInvite,
    resendInvite,
    deleteInvite
};

export default InviteService
