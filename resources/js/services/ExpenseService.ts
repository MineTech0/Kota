import axios from "axios"
import { GroupExpense } from "../types"

const storeGroupExpenses = async (expenses:GroupExpense[]) => {
    const requests = expenses.map(expense => axios.post('/expenses/group',expense))
    const responses = await Promise.all(requests)
    return responses.map(res => res.data)

}

const ExpenseService = {
    storeGroupExpenses,
};

export default ExpenseService