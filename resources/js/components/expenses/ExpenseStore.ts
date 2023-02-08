import { defineStore } from "pinia";
import { GroupExpense } from "../../types";

interface State {
    groupExpenses: GroupExpense[]
}

const today = new Date().getTime();

const defaultState = {
    groupExpenses: [
        {
            groupId: null,
            amount: 0,
            expense_date: today,
            description: "",
        },
    ]
}

export const useExpensesStore = defineStore('loan', {
    state: (): State => ({...defaultState}),
    actions: {
        /**
         * Adds new empty groupExpense
         */
        addGroupExpense(){
            this.groupExpenses.push({
                groupId: null,
                amount: 0,
                expense_date: today,
                description: "",
            });
        },
        /**
         * Deletes group expense from store
         * @param index number
         */
        removeGroupExpense(index){
            this.groupExpenses.splice(index, 1);
        },

        /**
         * Resets groupExpenses
         */
        resetGroupExpenses(){
            this.groupExpenses = []
            this.addGroupExpense()
        }
    },
  })