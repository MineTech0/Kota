import { ClubMoney } from "@/types";
import axios from "axios";

const saveClubMoney = async (clubMoney: ClubMoney) => {
   const response = await axios.post("/budget/clubMoney", clubMoney);
   return response.data;
  
}

const BudgetService = {
    saveClubMoney
};

export default BudgetService;
