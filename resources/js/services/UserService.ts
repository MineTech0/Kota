import { User } from "@/types";
import axios from "axios";

const updateUser = async (id: number, editedUser: User) => {
    const response = await axios.patch(`/users/${id}`,editedUser)
    return response.data
}

const deleteUser = async (id: number) => {
    const response = await axios.delete(`/users/${id}`)
    return response.data
}

const updateUserRoles = async (id: number, roles: number[]) => {
    const response = await axios.patch(`/users/${id}/roles`,{roles})
    return response.data
}

const UserService = {
    updateUser,
    deleteUser,
    updateUserRoles
}

export default UserService;
