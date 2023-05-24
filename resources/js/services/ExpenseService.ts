import axios from "axios"
import { NewGroupExpense } from "../types"

interface StoreResponse {
    message: string
}

const storeGroupExpenses = async (expenses:NewGroupExpense[]) : Promise<StoreResponse[]> =>  {
    const requests = expenses.map(expense => axios.post('/expenses/group',expense))
    const responses = await Promise.all(requests)
    return responses.map(res => res.data)

}

const ExpenseService = {
    storeGroupExpenses,
};

export default ExpenseService