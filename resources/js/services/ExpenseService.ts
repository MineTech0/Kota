import axios from "axios"
import { NewGroupExpense } from "../types"

interface StoreResponse {
    message: string
}

const storeGroupExpenses = async (expenses:NewGroupExpense[]) =>  {
    const requests = expenses.map(expense => axios.post('/expenses/group',expense))
    const responses = await Promise.all(requests)
    console.log(responses)
    return responses.map(res => res.data)[0]

}

const deleteExpense = async (id:number) => {
    const response = await axios.delete(`/expenses/${id}`)
    return response.data
}
const ExpenseService = {
    storeGroupExpenses,
    deleteExpense
};

export default ExpenseService