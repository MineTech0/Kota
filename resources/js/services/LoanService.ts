import axios from "axios"
import { LoanForm } from './../types.d';

const storeLoan = async (loan:LoanForm) => {
    const response = await axios.post('/loan',loan)
    return response.data      
}
const getLoan = async (loanId:number) => { 
    const response = await axios.get(`/loan/${loanId}`)
    return response.data
 }

 const returnLoan = async (loanId: number) => { 
    const response = await axios.delete(`/loan/${loanId}`)
    return response.data
  }

const LoanService = {
    storeLoan,
    getLoan,
    returnLoan
};

export default LoanService